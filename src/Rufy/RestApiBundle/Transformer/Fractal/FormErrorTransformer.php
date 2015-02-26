<?php namespace Rufy\RestApiBundle\Transformer\Fractal;

use FOS\RestBundle\Util\ExceptionWrapper;
use League\Fractal;
use Rufy\RestApiBundle\Exception\InvalidFormException;

class FormErrorTransformer extends Fractal\TransformerAbstract
{
    public function transform(ExceptionWrapper $form)
    {

        $errors             = array();
        $children           = $form->getErrors()->all();

        foreach ($children as $child) {

            /**
             * @var $child Form
             */
            if (!$child->isValid()) {
                /**
                 * @var $childErrors FormError
                 */
                $childErrors    = $child->getErrors(true, true)->getChildren();

                /**
                 * Proprietà per creare il messaggio completo di errore
                 */
                $cause          = $childErrors->getCause()->getCause();
                if ($cause)
                    $cause      = $cause->getMEssage();
                $wrongValue     = $childErrors->getCause()->getInvalidValue();
                $msg            = $childErrors->getMessage();
                $name           = $child->getName();

                $errors['form_errors'][] = [

                    'name'          => $name,
                    'generic'       => $msg,
                    'wrong_value'   => $wrongValue,
                    'cause'         => $cause
                ];
            }
        }

        return $errors;
    }
}
