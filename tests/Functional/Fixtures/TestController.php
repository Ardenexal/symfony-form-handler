<?php


namespace Tests\Functional\Fixtures;


use Ardenexal\FormHandler\FormHandlerFactory;
use Ardenexal\FormHandler\RequestHandler\TwigRequestHandler;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TestController
{
    /**
     * @var TwigRequestHandler
     */
    private $handler;
    /**
     * @var FormHandlerFactory
     */
    private $formHandlerFactory;

    public function __construct(TwigRequestHandler $handler, FormHandlerFactory $formHandlerFactory)
    {
        $this->handler            = $handler;
        $this->formHandlerFactory = $formHandlerFactory;
    }

    /**
     * @param Request            $request
     * @param FormHandlerFactory $formHandlerFactory
     *
     * @return Response|null
     * @throws \Ardenexal\FormHandler\Exception\FormHandlerNotValidException
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function testAction(Request $request): Response
    {
        $factory = $this->formHandlerFactory->create(TestFormHandler::class, new TestData());

        return $this->handler->handle($request, $factory,[
            'template'=>'test.twig'
        ]);
    }
}