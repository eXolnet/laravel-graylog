<?php

namespace Exolnet\Graylog\Handler;

use Exolnet\Graylog\Processor\ExtraProcessor;
use Exolnet\Graylog\Processor\LaravelProcessor;
use Exolnet\Graylog\Transport\TransportFactory;
use Gelf\Publisher;
use Monolog\Handler\GelfHandler;
use Monolog\Logger;
use Monolog\Processor\IntrospectionProcessor;
use Monolog\Processor\MemoryPeakUsageProcessor;
use Monolog\Processor\MemoryUsageProcessor;
use Monolog\Processor\WebProcessor;

class GraylogHandler extends GelfHandler
{
    /**
     * @param string $transport
     * @param string $host
     * @param int    $port
     * @param string $path
     * @param int    $level
     * @param array  $extra
     */
    public function __construct(
        string $transport,
        string $host,
        int $port,
        string $path,
        $level = Logger::NOTICE,
        array $extra = []
    ) {
        $transport = $this->getTransportFactory()->make($transport, $host, $port, $path);
        $publisher = new Publisher($transport);

        parent::__construct($publisher, $level, true);

        // Processors will be called in the reverse order that they are listed below
        $this->pushProcessor(new ExtraProcessor($extra));
        $this->pushProcessor(new LaravelProcessor());
        $this->pushProcessor(new IntrospectionProcessor());
        $this->pushProcessor(new WebProcessor());
        $this->pushProcessor(new MemoryUsageProcessor());
        $this->pushProcessor(new MemoryPeakUsageProcessor());
    }

    /**
     * @return \Exolnet\Graylog\Transport\TransportFactory
     */
    protected function getTransportFactory(): TransportFactory
    {
        return app(TransportFactory::class);
    }
}
