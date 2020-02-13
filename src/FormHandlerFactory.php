<?php


namespace Ardenexal\FormHandler;


use FormHandler\Exception\FormHandlerNotValidException;
use LogicException;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class FormHandlerFactory
 *
 * @package Ardenexal\FormHandler
 */
class FormHandlerFactory
{
    /**
     * @var FormBuilderInterface
     */
    private $formFactory;
    /**
     * @var ContainerInterface
     */
    private $container;

    /** @var FormInterface */
    private $form;
    /**
     * @var FormHandlerInterface
     */
    private $formHandler;

    public function __construct(FormFactoryInterface $formFactory, ContainerInterface $container)
    {
        $this->formFactory = $formFactory;
        $this->container   = $container;
    }

    /**
     * @param string $class
     *
     * @param object $valueObject - Form data to set defaults and sync form with
     *
     * @throws FormHandlerNotValidException
     */
    public function create(string $class, object $valueObject): void
    {
        $formHandler = $this->container->get($class);
        if (!$formHandler instanceof FormHandlerInterface) {
            throw new FormHandlerNotValidException();
        }
        $this->formHandler = $formHandler;
        if ($formHandler->getName() !== null) {
            $this->form = $this->formFactory->createNamed($formHandler->getName(), $formHandler->getFormType(), $valueObject, $formHandler->getOptions());
        } else {
            $this->form = $this->formFactory->create($formHandler->getFormType(), $valueObject, $formHandler->getOptions());
        }
    }

    /**
     * Handler Form request
     *
     * @param Request $request
     *
     * @return Response
     */
    public function handle(Request $request): Response
    {
        if (!$this->form instanceof FormInterface) {
            throw new LogicException('Form must be created before handling request');
        }

        $this->form->handleRequest($request);

        if ($this->form->isSubmitted() === false) {
            return null;
        }

        if ($this->form->isValid() === true) {
            return $this->formHandler->onSuccess($this->form->getData(), $this->form, $request);
        }

        return $this->formHandler->onError($this->form->getData(), $this->form, $request);
    }
}