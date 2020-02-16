<?php


namespace Tests\Functional;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpKernel\Kernel;
use Tests\Functional\Fixtures\TestKernel;

class ControllerTest extends WebTestCase
{
    private $test_client;

    /**
     * BC for current tests, new tests should get their own config.
     */
    protected function setUp()
    {
        $this->test_client = static::createClient();
    }

    protected static function createKernel(array $options = array())
    {
        return new TestKernel($options);
    }

    public function testActionInterfaceDependencyInjection()
    {
        if (Kernel::VERSION_ID < 30300) {
            self::markTestSkipped(sprintf('Symfony version %s not supported by test', Kernel::VERSION));
        }

        $crawler = $this->test_client->request('GET', '/');

        self::assertSame('test', $crawler->text());
    }
}