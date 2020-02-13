<?php


namespace Ardenexal\FormHandler;


use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

interface FormHandlerInterface
{
    /**
     * @return string
     */
    public function getFormType(): string;

    /**
     * @return array
     */
    public function getOptions(): array;

    /**
     * @return string|null
     */
    public function getName(): ?string;

    /**
     * @param               $formObject
     * @param FormInterface $form
     * @param Request       $request
     *
     * @return Response
     */
    public function onSuccess($formObject, FormInterface $form, Request $request);

    /**
     * @param               $formObject
     * @param FormInterface $form
     * @param Request       $request
     *
     * @return Response
     */
    public function onError($formObject, FormInterface $form, Request $request);
}