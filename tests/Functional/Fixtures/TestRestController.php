<?php


namespace Tests\Functional\Fixtures;


use Ardenexal\FormHandler\Exception\FormHandlerNotValidException;
use Ardenexal\FormHandler\FormHandlerFactory;
use Ardenexal\FormHandler\RequestHandler\RestRequestHandler;
use Ardenexal\FormHandler\RequestHandler\TwigRequestHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class TestRestController extends AbstractController
{
    /**
     * @var TwigRequestHandler
     */
    private $requestHandler;
    /**
     * @var FormHandlerFactory
     */
    private $formHandlerFactory;

    public function __construct(RestRequestHandler $handler, FormHandlerFactory $formHandlerFactory)
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
    public function getTest(Request $request): Response
    {
        $resolvedFormHandler = $this->formHandlerFactory->create(TestFormHandler::class, new TestValueObject());

        return $this->requestHandler->buildResponse($request, $resolvedFormHandler);
    }

    /**
     * @param Request $request
     *
     * @return Response
     * @throws FormHandlerNotValidException
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function postTest(Request $request): Response
    {
        $resolvedFormHandler = $this->formHandlerFactory->create(TestFormHandler::class, new TestValueObject());

        return $this->requestHandler->buildResponse($request, $resolvedFormHandler);
    }

    /**
     * @param Request $request
     *
     * @return Response
     * @throws FormHandlerNotValidException
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function putTest(Request $request, string $testId): Response
    {
        $data       = new TestValueObject();
        $data->test = 'test string';

        $resolvedFormHandler = $this->formHandlerFactory->create(TestFormHandler::class, $data);

        return $this->requestHandler->buildResponse($request, $resolvedFormHandler);
    }
}