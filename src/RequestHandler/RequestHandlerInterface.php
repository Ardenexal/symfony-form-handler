<?php


namespace Ardenexal\FormHandler\RequestHandler;


use Ardenexal\FormHandler\FormHandlerFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Interface RequestHandlerInterface
 *
 * @package Ardenexal\FormHandler\Handlers
 */
interface RequestHandlerInterface
{
    /**
     * @param Request                     $request
     *
     * @param FormHandlerFactoryInterface $formHandlerFactory
     *
     * @return Response
     */
    public function handle(Request $request, FormHandlerFactoryInterface $formHandlerFactory): Response;
}