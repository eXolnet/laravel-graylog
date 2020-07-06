<?php

namespace Exolnet\Graylog\Handler;

use Exolnet\Graylog\Processor\ExtraProcessor;
use Exolnet\Graylog\Processor\LaravelProcessor;
use Gelf\Publisher;
use Gelf\Transport\HttpTransport;
use Gelf\Transport\SslOptions;
use Gelf\Transport\TcpTransport;
use Gelf\Transport\UdpTransport;
use InvalidArgumentException;
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
     * @param bool   $secure
     * @param string $host
     * @param int    $port
     * @param string $path
     * @param int    $level
     * @param array  $extra
     */
    public function __construct(
        string $transport,
        bool $secure,
        string $host,
        int $port,
        string $path,
        $level = Logger::NOTICE,
        array $extra = []
    ) {
        $transport = self::makeTransport($transport, $secure, $host, $port, $path);
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
     * @param string $transport
     * @param bool   $secure
     * @param string $host
     * @param int    $port
     * @param string $path
     * @return \Gelf\Transport\TransportInterface
     * @throws \InvalidArgumentException
     */
    protected static function makeTransport(string $transport, bool $secure, string $host, int $port, string $path)
    {
        if ($transport === 'udp') {
            return new UdpTransport($host, $port);
        } elseif ($transport === 'tcp') {
            return new TcpTransport($host, $port, ($secure) ? new SslOptions() : null);
        } elseif ($transport === 'http') {
            return new HttpTransport($host, $port, $path, ($secure) ? new SslOptions() : null);
        } elseif ($transport === 'https') {
            return new HttpTransport($host, $port, $path, new SslOptions());
        } else {
            throw new InvalidArgumentException("Transport [{$transport}] is not supported.");
        }
    }
}
