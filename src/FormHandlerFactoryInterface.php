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
     * @return ResolvedFormHandler
     */
    public function create(string $class, object $valueObject): ResolvedFormHandler;
}