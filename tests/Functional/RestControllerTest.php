<?php


namespace Tests\Functional;


use Ardenexal\FormHandler\FormHandlerFactory;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Kernel;
use Tests\Functional\Fixtures\TestKernel;

class RestControllerTest extends WebTestCase
{
    private $test_client;

    /**
     * BC for current tests, new tests should get their own config.
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->test_client = static::createClient();
    }

    protected static function createKernel(array $options = array())
    {
        return new TestKernel('test', true);
    }

    /**
     *
     */
    public function testFormHandlerFactoryServiceExists(): void
    {
        $kernel = $this->test_client;
        /** @var ContainerInterface $container */
        $container          = $kernel->getContainer();
        $formHandlerFactory = $container->get(FormHandlerFactory::class);
        $this->assertInstanceOf(FormHandlerFactory::class, $formHandlerFactory);
    }

    public function testGetAction(): void
    {
        if (Kernel::VERSION_ID < 30300) {
            self::markTestSkipped(sprintf('Symfony version %s not supported by test', Kernel::VERSION));
        }

        $this->test_client->request('GET', '/rest');
        self::assertResponseStatusCodeSame(405);
    }

    public function testPostAction(): void
    {
        if (Kernel::VERSION_ID < 30300) {
            self::markTestSkipped(sprintf('Symfony version %s not supported by test', Kernel::VERSION));
        }

        $this->test_client->request('POST', '/rest',
                                    [],
                                    [],
                                    ['CONTENT_TYPE' => 'application/json'],
                                    '{"test":"Post Data"}');
        self::assertResponseStatusCodeSame(200);
    }

    public function testPostFailedAction(): void
    {
        if (Kernel::VERSION_ID < 30300) {
            self::markTestSkipped(sprintf('Symfony version %s not supported by test', Kernel::VERSION));
        }

        $this->test_client->request('POST', '/rest',
                                    [],
                                    [],
                                    ['CONTENT_TYPE' => 'application/json'],
                                    '{"invalidField":"Post Data"}');
        self::assertResponseStatusCodeSame(400);
        self::assertEquals($this->test_client->getResponse()->getContent(), '{"":["This form should not contain extra fields."],"test":["This value should not be blank."]}');
    }

    public function testPutSuccessAction(): void
    {
        if (Kernel::VERSION_ID < 30300) {
            self::markTestSkipped(sprintf('Symfony version %s not supported by test', Kernel::VERSION));
        }

        $this->test_client->request('PUT', '/rest/1',
                                    [],
                                    [],
                                    ['CONTENT_TYPE' => 'application/json'],
                                    '{"test":"PUT Data"}');
        self::assertResponseStatusCodeSame(200);
    }

    public function testPatchSuccessAction(): void
    {
        if (Kernel::VERSION_ID < 30300) {
            self::markTestSkipped(sprintf('Symfony version %s not supported by test', Kernel::VERSION));
        }

        $this->test_client->request('PATCH', '/rest/1',
                                    [],
                                    [],
                                    ['CONTENT_TYPE' => 'application/json'],
                                    '{"test":"Patch Data"}');
        self::assertResponseStatusCodeSame(200);
    }
}