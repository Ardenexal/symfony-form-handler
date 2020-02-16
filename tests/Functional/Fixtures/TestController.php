<?php


namespace Tests\Functional\Fixtures;


use Ardenexal\FormHandler\FormHandlerFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TestController
{
    /**
     * @param Request            $request
     * @param FormHandlerFactory $formHandlerFactory
     *
     * @return Response|null
     * @throws \Ardenexal\FormHandler\Exception\FormHandlerNotValidException
     */
    public function testAction(Request $request, FormHandlerFactory $formHandlerFactory)
    {
        $factory = $formHandlerFactory->create(TestFormHandler::class, new TestData());

        $response = $factory->handle($request);

        if ($response instanceof Response) {
            return $response;
        }

        return new Response('test');
    }
}