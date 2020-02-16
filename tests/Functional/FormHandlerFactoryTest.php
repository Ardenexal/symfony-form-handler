<?php
//
//
//namespace Tests\Functional;
//
//
//use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
//use Tests\Functional\Fixtures\TestKernel;
//
//class FormHandlerFactoryTest extends KernelTestCase
//{
//    /**
//     * BC for current tests, new tests should get their own config.
//     */
//    protected function setUp()
//    {
//        static::bootKernel(['config_file' => TestKernel::getLegacyConfigFilename()]);
//    }
//
//    protected static function createKernel(array $options = array())
//    {
//        return new TestKernel($options);
//    }
//
//    public function testValid()
//    {
//        if (Kernel::VERSION_ID < 20800) {
//            self::markTestSkipped(sprintf('Symfony version %s not supported by test', Kernel::VERSION));
//        }
//
//        $container       = self::$kernel->getContainer();
//        $handler_factory = $container->get('hostnet.form_handler.factory');
//        $request         = Request::create('/', 'POST', ['test' => ['test' => 'foobar']]);
//
//        $handler = $handler_factory->create(FullFormHandler::class);
//        $data    = new TestData();
//
//        $response = $handler->handle($request, $data);
//
//        self::assertInstanceOf(RedirectResponse::class, $response);
//        self::assertEquals('http://success.nl/', $response->getTargetUrl());
//    }
//
//    public function testInvalid()
//    {
//        if (Kernel::VERSION_ID < 20800) {
//            self::markTestSkipped(sprintf('Symfony version %s not supported by test', Kernel::VERSION));
//        }
//
//        $container       = self::$kernel->getContainer();
//        $handler_factory = $container->get('hostnet.form_handler.factory');
//        $request         = Request::create('/', 'POST', ['test' => ['test' => null]]);
//
//        $handler = $handler_factory->create(FullFormHandler::class);
//        $data    = new TestData();
//
//        $response = $handler->handle($request, $data);
//
//        self::assertInstanceOf(RedirectResponse::class, $response);
//        self::assertEquals('http://failure.nl/', $response->getTargetUrl());
//    }
//
//    /**
//     * @group legacy
//     */
//    public function testValid27()
//    {
//        if (Kernel::VERSION_ID >= 30000) {
//            self::markTestSkipped(sprintf('Symfony version %s not supported by test', Kernel::VERSION));
//        }
//
//        $container       = self::$kernel->getContainer();
//        $handler_factory = $container->get('hostnet.form_handler.factory');
//        $request         = Request::create('/', 'POST', ['test' => ['test' => 'foobar']]);
//
//        $handler = $handler_factory->create(FullFormHandler27::class);
//        $data    = new TestData();
//
//        $response = $handler->handle($request, $data);
//
//        self::assertInstanceOf(RedirectResponse::class, $response);
//        self::assertEquals('http://success.nl/', $response->getTargetUrl());
//    }
//
//    /**
//     * @group legacy
//     */
//    public function testInvalid27()
//    {
//        if (Kernel::VERSION_ID >= 30000) {
//            self::markTestSkipped(sprintf('Symfony version %s not supported by test', Kernel::VERSION));
//        }
//
//        $container       = self::$kernel->getContainer();
//        $handler_factory = $container->get('hostnet.form_handler.factory');
//        $request         = Request::create('/', 'POST', ['test' => ['test' => null]]);
//
//        $handler = $handler_factory->create(FullFormHandler27::class);
//        $data    = new TestData();
//
//        $response = $handler->handle($request, $data);
//
//        self::assertInstanceOf(RedirectResponse::class, $response);
//        self::assertEquals('http://failure.nl/', $response->getTargetUrl());
//    }
//}