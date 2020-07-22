<?php

namespace Exolnet\Graylog\Tests\Feature;

use Exolnet\Graylog\Handler\GraylogHandler;
use Illuminate\Log\Logger as IlluminateLogger;
use Monolog\Logger as MonologLogger;

class GraylogDriverTest extends TestCase
{
    /**
     * @var \Illuminate\Log\LogManager
     */
    protected $logManager;

    /**
     * @var \Illuminate\Log\Logger
     */
    protected $channel;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->app['config']->set('logging.channels.graylog', [
            'driver' => 'graylog',
        ]);

        $this->logManager = $this->app->make('log');
        $this->channel = $this->logManager->channel('graylog');
    }

    /**
     * @return void
     * @test
     */
    public function testIsAnIlluminateLogger(): void
    {
        $this->assertInstanceOf(IlluminateLogger::class, $this->channel);
    }

    /**
     * @return void
     * @test
     */
    public function testUseAMonologDriver(): void
    {
        $this->assertInstanceOf(MonologLogger::class, $this->channel->getLogger());
    }

    /**
     * @return void
     * @test
     */
    public function testUseGraylogHandler(): void
    {
        /** @var \Monolog\Logger $logger */
        $logger = $this->channel->getLogger();
        $handlers = $logger->getHandlers();

        $this->assertInstanceOf(GraylogHandler::class, $handlers[0] ?? null);
    }
}
