<?php


namespace Ardenexal\FormHandler\DependencyInjection;


use Ardenexal\FormHandler\FormHandlerInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader;

class FormHandlerExtension extends Extension
{


    /**
     * Loads a specific configuration.
     *
     * @param array            $configs
     * @param ContainerBuilder $container
     *
     * @throws \Exception
     */
    public function load(array $configs, ContainerBuilder $container): void
    {
        $configuration = new Configuration();
        $this->processConfiguration($configuration, $configs);
        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yaml');

        // If auto configuring is available, register tags for the Handler Types.
        if (method_exists($container, 'registerForAutoconfiguration')) {
            $container->registerForAutoconfiguration(FormHandlerInterface::class)->addTag('form.handler');
        }
    }
}