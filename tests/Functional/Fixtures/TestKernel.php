<?php


namespace Tests\Functional\Fixtures;


use Ardenexal\FormHandler\FormHandlerBundle;
use Ardenexal\FormHandler\FormHandlerFactory;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Bundle\TwigBundle\TwigBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel;

class TestKernel extends Kernel
{

    /**
     * {@inheritdoc}
     */
    public function registerBundles()
    {
        return array(
            new TwigBundle(),
            new FrameworkBundle(),
            new FormHandlerBundle(),
        );
    }

    /**
     * Loads the container configuration.
     *
     * @param LoaderInterface $loader
     *
     * @throws \Exception
     */
    public function registerContainerConfiguration(LoaderInterface $loader): void
    {
        $loader->load(__DIR__ . '/config/services.yaml');
    }
}