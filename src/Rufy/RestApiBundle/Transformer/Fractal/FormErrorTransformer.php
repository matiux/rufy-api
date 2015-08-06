<?php namespace Rufy\RestApiBundle\Transformer\Fractal;

use FOS\RestBundle\Util\ExceptionWrapper;
use League\Fractal;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormErrorIterator;

class FormErrorTransformer extends Fractal\TransformerAbstract
{
    public function transform(ExceptionWrapper $form)
    {
        $errors             = array();
        $children           = $form->getErrors();

        if ($children) {

            $children = $children->all();

            foreach ($children as $child) {

                /**
                 * @var $child Form
                 */
                if ( ! $child->isValid()) {
                    /**
                     * @var $childErrors FormError
                     */
                    $childErrors = $child->getErrors(true, true)->getChildren();

                    if ($childErrors) {

                        /**
                         * Proprietà per creare il messaggio completo di errore
                         */
                        $cause = $childErrors->getCause()->getCause();
                        if ($cause)
                            $cause = $cause->getMEssage();
                        $wrongValue = $childErrors->getCause()->getInvalidValue();
                        $msg = $childErrors->getMessage();


                        $propertyPath = explode('.', $childErrors->getCause()->getPropertyPath());

                        if (2 < count($propertyPath)) {
                            $name = "{$propertyPath[1]}[$propertyPath[2]]";
                        }
                        else {
                            $name = $propertyPath[1];
                        }

                        //$name = $child->getName();

                        $errors['form_errors'][] = [

                            'name' => $name,
                            'generic' => $msg,
                            'wrong_value' => $wrongValue,
                            'cause' => $cause
                        ];
                    }
                }
            }

        }


        if (!$children || empty($errors)) {

            $arrayErrors = [];

            /**
             * @var $errors Form
             */
            $formErrors = $form->getErrors()->getErrors();
            if (0 < count($formErrors) && $formErrors instanceof FormErrorIterator ) {
                foreach($formErrors as $e) {

                    /**
                     * @var $e FormError
                     */

                    array_push($arrayErrors, [

                        'message'       => $e->getMessage(),
                        'parameters'    => $e->getMessageParameters(),
                    ]);
                }
            }

            $errors['form_errors'] = [

                'code'          => $form->getCode(),
                'message'       => stripslashes($form->getMessage()),
                'errors'        => $form->getErrors(),
            ];

            if (!empty($arrayErrors)) {
                $errors['form_errors']['errors_det'] = $arrayErrors;
            }
        }

        return $errors;
    }
}
