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
     */
    public function testIsAnIlluminateLogger(): void
    {
        $this->assertInstanceOf(IlluminateLogger::class, $this->channel);
    }

    /**
     * @return void
     */
    public function testUseAMonologDriver(): void
    {
        $this->assertInstanceOf(MonologLogger::class, $this->channel->getLogger());
    }

    /**
     * @return void
     */
    public function testUseGraylogHandler(): void
    {
        /** @var \Monolog\Logger $logger */
        $logger = $this->channel->getLogger();
        $handlers = $logger->getHandlers();

        $this->assertInstanceOf(GraylogHandler::class, $handlers[0] ?? null);
    }

    /**
     * @return void
     */
    public function testLogging(): void
    {
        $socket = socket_create(AF_INET, SOCK_DGRAM, 0);
        socket_bind($socket, '127.0.0.1', 12201);

        $this->channel->info('Test message');

        socket_recvfrom($socket, $buffer, 1024, MSG_DONTWAIT, $remoteIp, $remotePort);

        $json = json_decode(gzuncompress($buffer), true);

        $this->assertEquals('1.0', $json['version']);
        $this->assertEquals('Test message', $json['short_message']);
        $this->assertEquals(6, $json['level']);
        $this->assertEquals('laravel', $json['_app']);
        $this->assertEquals('INFO', $json['_level_name']);
        $this->assertEquals('testing', $json['_env']);
        $this->assertEquals('Symfony', $json['_user_agent']);
    }
}
