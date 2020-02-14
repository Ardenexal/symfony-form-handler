<?php


namespace Ardenexal\FormHandler;


use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class FormHandlerBundle extends Bundle
{
    /**
     * @param ContainerBuilder $container
     */
    public function build(ContainerBuilder $container): void
    {
        parent::build($container);

        // If auto configuring is available, register tags for the Handler Types.
        if (method_exists($container, 'registerForAutoconfiguration')) {
            $container->registerForAutoconfiguration(FormHandlerInterface::class)->addTag('form.handler');
        }
    }
}