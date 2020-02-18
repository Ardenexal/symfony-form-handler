<?php


namespace Tests\Functional;


use Ardenexal\FormHandler\FormHandlerFactory;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpKernel\Kernel;
use Tests\Functional\Fixtures\TestKernel;

class ControllerTest extends WebTestCase
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

    public function testFormHandlerFactoryServiceExists()
    {
        $kernel = $this->test_client;
        /** @var ContainerInterface $container */
        $container          = $kernel->getContainer();
        $formHandlerFactory = $container->get(FormHandlerFactory::class);
        $this->assertInstanceOf(FormHandlerFactory::class, $formHandlerFactory);
    }

    public function testGetAction()
    {
        if (Kernel::VERSION_ID < 30300) {
            self::markTestSkipped(sprintf('Symfony version %s not supported by test', Kernel::VERSION));
        }

        $crawler = $this->test_client->request('GET', '/');

        self::assertSame('Test Submit', $crawler->text());
    }

    public function testPostAction()
{
    if (Kernel::VERSION_ID < 30300) {
        self::markTestSkipped(sprintf('Symfony version %s not supported by test', Kernel::VERSION));
    }

    $this->test_client->request('GET', '/');
    $this->test_client->submitForm('Submit', [
        'test' => 'test',
    ]);
    self::assertResponseStatusCodeSame(200);
}
    public function testPostFailedAction()
    {
        if (Kernel::VERSION_ID < 30300) {
            self::markTestSkipped(sprintf('Symfony version %s not supported by test', Kernel::VERSION));
        }

        $this->test_client->request('GET', '/');
        $this->test_client->submitForm('Submit', [
        ]);
        self::assertResponseStatusCodeSame(400);
        self::assertEquals($this->test_client->getResponse()->getContent(),"{\"test\":[\"This value should not be blank.\"]}");
    }
}