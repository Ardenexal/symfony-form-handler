<?php


namespace Tests\Functional;


use Ardenexal\FormHandler\FormHandlerFactory;
use Ardenexal\FormHandler\FormHandlerFactoryInterface;
use Ardenexal\FormHandler\FormHandlerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Form\FormInterface;
use Tests\Functional\Fixtures\TestData;
use Tests\Functional\Fixtures\TestFormHandler;
use Tests\Functional\Fixtures\TestKernel;

class FormHandlerFactoryTest extends KernelTestCase
{
    /**
     * BC for current tests, new tests should get their own config.
     */
    protected function setUp(): void
    {
        parent::setUp();
        static::bootKernel();
    }

    protected static function createKernel(array $options = array())
    {
        return new TestKernel('test', true);
    }

    public function testServiceExists(): void
    {
        $handler_factory = self::$container->get(FormHandlerFactory::class);

        $handler = $handler_factory->create(TestFormHandler::class, new TestData());


        self::assertInstanceOf(FormHandlerFactoryInterface::class, $handler);
    }

    public function testFactoryReturnsValid(): void
    {
        $handler_factory = self::$container->get(FormHandlerFactory::class);

        $handler = $handler_factory->create(TestFormHandler::class, new TestData());


        self::assertInstanceOf(FormHandlerInterface::class, $handler->getFormHandler());
        self::assertInstanceOf(FormInterface::class, $handler->getForm());
    }
}