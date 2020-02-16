<?php


namespace Ardenexal\FormHandler\RequestHandler;


use Ardenexal\FormHandler\FormHandlerFactoryInterface;
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
     * @param Request                     $request
     *
     * @param FormHandlerFactoryInterface $formHandlerFactory
     *
     * @param array                       $options
     *
     * @return Response
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function handle(Request $request, FormHandlerFactoryInterface $formHandlerFactory, array $options = []): Response
    {
        $form        = $formHandlerFactory->getForm();
        $formHandler = $formHandlerFactory->getFormHandler();
        if (!$form instanceof FormInterface) {
            throw new LogicException('Form must be created before handling request');
        }

        $form->handleRequest($request);

        /*
         * The form will not be submitted on a GET request
         */
        if ($form->isSubmitted() === false) {
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

        if ($form->isValid() === true) {
            return $formHandler->onSuccess($form->getData(), $form, $request);
        }

        return $formHandler->onError($form->getData(), $form, $request);
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