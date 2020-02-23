<?php


namespace Tests\Functional;


use Ardenexal\FormHandler\FormHandlerFactory;
use Ardenexal\FormHandler\FormHandlerInterface;
use Ardenexal\FormHandler\ResolvedFormHandler;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Form\FormInterface;
use Tests\Functional\Fixtures\TestFormHandler;
use Tests\Functional\Fixtures\TestKernel;
use Tests\Functional\Fixtures\TestValueObject;

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

    /**
     * @throws \Ardenexal\FormHandler\Exception\FormHandlerNotValidException
     */
    public function testServiceExists(): void
    {
        $handler_factory = self::$container->get(FormHandlerFactory::class);

        $resolvedFormHandler = $handler_factory->create(TestFormHandler::class, new TestValueObject());


        self::assertInstanceOf(ResolvedFormHandler::class, $resolvedFormHandler);
    }

    /**
     * @throws \Ardenexal\FormHandler\Exception\FormHandlerNotValidException
     */
    public function testFactoryReturnsValid(): void
    {
        $handler_factory = self::$container->get(FormHandlerFactory::class);

        $resolvedFormHandler = $handler_factory->create(TestFormHandler::class, new TestValueObject());


        self::assertInstanceOf(FormHandlerInterface::class, $resolvedFormHandler->getFormHandler());
        self::assertInstanceOf(FormInterface::class, $resolvedFormHandler->getForm());
    }
}