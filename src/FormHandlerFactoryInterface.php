<?php


namespace Ardenexal\FormHandler;


use Symfony\Component\Form\FormInterface;

interface FormHandlerFactoryInterface
{
    /**
     * @param string $class
     *
     * @param object $valueObject - Form data to set defaults and sync form with
     *
     * @return FormHandlerFactoryInterface
     */
    public function create(string $class, object $valueObject): FormHandlerFactoryInterface;

    /**
     * @return FormInterface
     */
    public function getForm(): FormInterface;

    /**
     * @return FormHandlerInterface
     */
    public function getFormHandler(): FormHandlerInterface;
}