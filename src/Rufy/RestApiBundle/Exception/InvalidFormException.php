<?php namespace Rufy\RestApiBundle\Exception;


use Symfony\Component\Form\Form,
    Symfony\Component\Form\FormErrorIterator,
    Symfony\Component\Form\FormError;

class InvalidFormException extends \RuntimeException
{
    protected $form;
    protected $errors;

    /**
     * @param string $message
     * @param Form $form
     */
    public function __construct($message, Form $form = null)
    {
        $this->errors       = array();

        /**
         * Prendo gli elementi del form
         */
        $children           = $form->all();

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
                //$propertyError  = $child->getPropertyPath()->getElement(0); //$child->getName()
                $cause          = $childErrors->getCause()->getCause()->getMEssage();
                $wrongValue     = $childErrors->getCause()->getInvalidValue();
                $msg            = $childErrors->getMessage();
                $name           = $child->getName();

                $this->errors['form_errors'] = [

                    'name'          => $name,
                    'generic'       => $msg,
                    'wrong_value'   => $wrongValue,
                    'cause'         => $cause
                ];
            }
        }

        parent::__construct($message);

        $this->form = $form;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @return array|null
     */
    public function getForm()
    {
        return $this->form;
    }
}
