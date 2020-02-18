<?php


namespace Ardenexal\FormHandler;


use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormErrorIterator;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class AbstractFormHandler
 *
 * @package Ardenexal\FormHandler
 */
class AbstractFormHandler implements FormHandlerInterface
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
     * @return string|null
     */
    public function getName(): ?string
    {
        return '';
    }

    /**
     * @param mixed         $formObject
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
     * @param mixed         $formObject
     * @param FormInterface $form
     * @param Request       $request
     *
     * @return Response
     */
    public function onError($formObject, FormInterface $form, Request $request): Response
    {
        return new JsonResponse($this->getFormErrors($form), Response::HTTP_BAD_REQUEST);
    }

    /**
     * @param FormInterface $form
     *
     * @return array
     */
    protected function getFormErrors(FormInterface $form): array
    {
        $errors = array();

        /** @var FormError $error */
        foreach ($form->getErrors() as $error) {
            $errors[$form->getName()][] = $error->getMessage();
        }

        // Fields
        foreach ($form as $child/** @var FormInterface $child */) {
            if ($child->isSubmitted() && !$child->isValid()) {
                foreach ($child->getErrors() as $error) {
                    $errors[$child->getName()][] = $error->getMessage();
                }
            }
        }

        return $errors;
    }
}