<?php namespace Rufy\RestApiBundle\Exception;


use Symfony\Component\Form\Form;

class InvalidFormException extends \RuntimeException
{
    protected $form;

    public function __construct($message, Form $form = null)
    {
        $children = $form->all();

        foreach ($children as $child) {
            if (!$child->isValid()) {
                $errors[$child->getName()] = (string) $child->getErrors();
            }
        }

        parent::__construct(implode(' - ', $errors));

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
