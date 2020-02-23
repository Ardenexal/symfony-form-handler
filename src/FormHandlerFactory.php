<?php


namespace Ardenexal\FormHandler;


use Ardenexal\FormHandler\Exception\FormHandlerNotValidException;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;

/**
 * Class FormHandlerFactory
 *
 * @package Ardenexal\FormHandler
 */
class FormHandlerFactory implements FormHandlerFactoryInterface
{
    /**
     * @var FormFactoryInterface
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
     * @return ResolvedFormHandler
     * @throws FormHandlerNotValidException
     */
    public function create(string $class, object $valueObject): ResolvedFormHandler
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

        return new ResolvedFormHandler($this->form, $formHandler);
    }
}