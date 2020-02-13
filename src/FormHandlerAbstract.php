<?php


namespace Ardenexal\FormHandler;


use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class FormHandlerAbstract
 *
 * @package Ardenexal\FormHandler
 */
class FormHandlerAbstract implements FormHandlerInterface
{
    /**
     * @return string
     */
    public function getFormType(): string
    {
        return FormType::class;
    }

    /**
     * @return array
     */
    public function getOptions(): array
    {
        return [];
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return null;
    }

    /**
     * @param               $formObject
     * @param FormInterface $form
     * @param Request       $request
     *
     * @return Response
     */
    public function onSuccess($formObject, FormInterface $form, Request $request): Response
    {
        return new JsonResponse(['message' => 'OK'], Response::HTTP_OK);
    }

    /**
     * @param               $formObject
     * @param FormInterface $form
     * @param Request       $request
     *
     * @return Response
     */
    public function onError($formObject, FormInterface $form, Request $request): Response
    {
        return new JsonResponse($form->getErrors(), Response::HTTP_BAD_REQUEST);
    }
}