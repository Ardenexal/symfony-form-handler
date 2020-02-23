<?php


namespace Ardenexal\FormHandler\RequestHandler;


use Ardenexal\FormHandler\FormHandlerFactoryInterface;
use Ardenexal\FormHandler\ResolvedFormHandler;
use LogicException;
use Psr\Container\ContainerInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TwigRequestHandler implements RequestHandlerInterface
{

    /**
     * @var \Twig\Environment
     */
    private $twig;

    public function __construct(ContainerInterface $container)
    {
        if (!$container->has('twig')) {
            throw new \LogicException('You can not use the "renderView" method if the Templating Component or the Twig Bundle are not available. Try running "composer require symfony/twig-bundle".');
        }

        $this->twig = $container->get('twig');
    }

    /**
     * @param Request             $request
     *
     * @param ResolvedFormHandler $resolvedResolvedFormHandler
     *
     * @param array               $options
     *
     * @return Response
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
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

        $form->handleRequest($request);

        /*
         * The form will not be submitted on a GET request
         */

        // If form is submitted it will be a POST request
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                return $formHandler->onSuccess($form->getData(), $form, $request);
            }

            return $formHandler->onError($form->getData(), $form, $request);
        }

        // If form has not been submitted then it will be a GET request
        $viewData = [];
        if (array_key_exists('template', $options) === false) {
            throw new \RuntimeException('Must include template in options to render twig template');
        }

        if (array_key_exists('viewData', $options) === true) {
            $viewData = $options['viewData'];
        }

        $template = $options['template'];

        return new Response($this->renderForm($form, $template, $viewData));
    }

    /**
     * @param FormInterface $form
     * @param string        $template
     * @param array         $viewData
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    private function renderForm(FormInterface $form, string $template, array $viewData): string
    {
        $viewData['form'] = $form->createView();

        return $this->twig->render($template, $viewData);
    }
}