<?php namespace Rufy\RestApiBundle\Exception;


use Symfony\Component\Form\Form,
    Symfony\Component\Form\FormErrorIterator,
    Symfony\Component\Form\FormError;

class InvalidFormException extends \RuntimeException
{
    protected $form;

    /**
     * @param string $message
     * @param Form $form
     */
    public function __construct($message, Form $form = null)
    {
        parent::__construct($message);

        $this->form = $form;
    }

    /**
     * @return array|null
     */
    public function getForm()
    {
        return $this->form;
    }
}
