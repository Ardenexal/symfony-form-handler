<?php


namespace Ardenexal\FormHandler;


use Symfony\Component\Form\FormInterface;

class ResolvedFormHandler
{
    /** @var FormInterface */
    private $form;
    /** @var FormHandlerInterface */
    private $formHandler;

    public function __construct(FormInterface $form, FormHandlerInterface $formHandler)
    {
        $this->form        = $form;
        $this->formHandler = $formHandler;
    }

    /**
     * @return FormInterface
     */
    public function getForm(): FormInterface
    {
        return $this->form;
    }

    /**
     * @return FormHandlerInterface
     */
    public function getFormHandler(): FormHandlerInterface
    {
        return $this->formHandler;
    }
}