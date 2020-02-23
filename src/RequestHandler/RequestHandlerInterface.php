<?php


namespace Ardenexal\FormHandler\RequestHandler;


use Ardenexal\FormHandler\ResolvedFormHandler;
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
     * @param Request             $request
     *
     * @param ResolvedFormHandler $resolvedFormHandler
     *
     * @return Response
     */
    public function buildResponse(Request $request, ResolvedFormHandler $resolvedFormHandler): Response;
}