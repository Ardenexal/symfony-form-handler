<?php


namespace Ardenexal\FormHandler\RequestHandler;


use Ardenexal\FormHandler\FormHandlerFactoryInterface;
use Ardenexal\FormHandler\ResolvedFormHandler;
use LogicException;
use Psr\Container\ContainerInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

class RestRequestHandler implements RequestHandlerInterface
{
    /**
     * @param Request             $request
     *
     * @param ResolvedFormHandler $resolvedResolvedFormHandler
     *
     * @param array               $options
     *
     * @return Response
     */
    public function buildResponse(
        Request $request,
        ResolvedFormHandler $resolvedResolvedFormHandler,
        array $options = []): Response
    {
        $form        = $resolvedResolvedFormHandler->getForm();
        $formHandler = $resolvedResolvedFormHandler->getFormHandler();
        if (!$form instanceof FormInterface) {
            throw new LogicException('Form must be created before handling request');
        }

        $allowedMethods = [Request::METHOD_POST, Request::METHOD_PUT, Request::METHOD_PATCH];
        if (in_array($request->getMethod(), $allowedMethods, true)) {
            $body = $request->getContent();
            if (is_string($body) === false) {
                throw new \RuntimeException('Request content must be a string type');
            }
            $data = json_decode($body, true);
            // If the method is PATCH then don't clear fields not defined in the request
            $clearMissing = $request->getMethod() !== Request::METHOD_PATCH;
            $form->submit($data, $clearMissing);
            // If form is submitted it will be a POST request
            if ($form->isSubmitted()) {
                if ($form->isValid()) {
                    return $formHandler->onSuccess($form->getData(), $form, $request);
                }

                return $formHandler->onError($form->getData(), $form, $request);
            }
        }
        throw new MethodNotAllowedHttpException(['POST', 'PUT', 'PATCH']);
    }
}