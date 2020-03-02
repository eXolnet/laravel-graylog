<?php

namespace Exolnet\Graylog\Handler;

use Exolnet\Graylog\Processor\GraylogProcessor;
use Gelf\Publisher;
use Gelf\Transport\UdpTransport;
use Monolog\Handler\GelfHandler;
use Monolog\Logger;
use Monolog\Processor\IntrospectionProcessor;
use Monolog\Processor\MemoryPeakUsageProcessor;
use Monolog\Processor\MemoryUsageProcessor;
use Monolog\Processor\WebProcessor;

class GraylogHandler extends GelfHandler
{
    /**
     * @param string $host
     * @param int $port
     * @param int $level
     * @param array $extra
     */
    public function __construct(string $host, int $port, $level = Logger::NOTICE, array $extra = [])
    {
        $transport = new UdpTransport($host, $port);
        $publisher = new Publisher($transport);

        parent::__construct($publisher, $level, true);

        $this->pushProcessor(new IntrospectionProcessor());
        $this->pushProcessor(new WebProcessor());
        $this->pushProcessor(new MemoryUsageProcessor());
        $this->pushProcessor(new MemoryPeakUsageProcessor());
        $this->pushProcessor(new GraylogProcessor($extra));
    }
}
