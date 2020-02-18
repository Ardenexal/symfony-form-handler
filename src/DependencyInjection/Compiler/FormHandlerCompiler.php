<?php


namespace Ardenexal\FormHandler\DependencyInjection\Compiler;


use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class FormHandlerCompiler implements CompilerPassInterface
{

    /**
     * You can modify the container here before it is dumped to PHP code.
     */
    public function process(ContainerBuilder $container)
    {
        // find all service IDs with the app.mail_transport tag
        $taggedServices = $container->findTaggedServiceIds('form.handler');

        foreach ($taggedServices as $id => $tags) {
            // add the transport service to the TransportChain service
            $container->getDefinition($id)->setPublic(true);
        }
    }
}