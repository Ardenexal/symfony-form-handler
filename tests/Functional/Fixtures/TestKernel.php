<?php


namespace Tests\Functional\Fixtures;


use Ardenexal\FormHandler\FormHandlerBundle;
use Ardenexal\FormHandler\FormHandlerFactory;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel;

class TestKernel extends Kernel
{
    private $config_file;

    public function __construct(array $options)
    {
        $this->config_file = $options['config_file'] ?? 'config.yml';

        parent::__construct(
            $options['environment'] ?? 'test',
            $options['debug'] ?? true
        );
    }

    /**
     * {@inheritdoc}
     */
    public function registerBundles()
    {
        return array(
            new \Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new FormHandlerBundle(),
        );
    }

    /**
     * {@inheritdoc}
     * @throws \Exception
     */
    public function registerContainerConfiguration(LoaderInterface $loader): void
    {
        $loader->load(__DIR__ . "/config/{$this->config_file}");
    }

    protected function prepareContainer(ContainerBuilder $container)
    {
        parent::prepareContainer($container);

        $container->findDefinition(FormHandlerFactory::class)->setPublic(true);
    }

    /**
     * {@inheritdoc}
     */
    public function getCacheDir()
    {
        return __DIR__ . '/../../../var/cache/' . md5($this->getEnvironment() . $this->config_file);
    }

    /**
     * {@inheritdoc}
     */
    public function getLogDir()
    {
        return __DIR__ . '/../../../var/logs';
    }

}