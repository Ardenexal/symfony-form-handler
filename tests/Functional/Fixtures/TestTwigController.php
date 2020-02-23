<?php


namespace Tests\Functional\Fixtures;


use Ardenexal\FormHandler\Exception\FormHandlerNotValidException;
use Ardenexal\FormHandler\FormHandlerFactory;
use Ardenexal\FormHandler\RequestHandler\TwigRequestHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class TestTwigController extends AbstractController
{
    /**
     * @var TwigRequestHandler
     */
    private $requestHandler;
    /**
     * @var FormHandlerFactory
     */
    private $formHandlerFactory;

    public function __construct(TwigRequestHandler $handler, FormHandlerFactory $formHandlerFactory)
    {
        $this->requestHandler     = $handler;
        $this->formHandlerFactory = $formHandlerFactory;
    }

    /**
     * @param Request $request
     *
     * @return Response|null
     * @throws FormHandlerNotValidException
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function testAction(Request $request): Response
    {

        $resolvedFormHandler = $this->formHandlerFactory->create(TestFormHandler::class, new TestValueObject());

        return $this->requestHandler->buildResponse($request, $resolvedFormHandler, [
            'template' => 'test.twig',
        ]);
    }

}