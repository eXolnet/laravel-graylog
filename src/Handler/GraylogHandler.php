<?php

namespace Exolnet\Graylog\Handler;

use Exolnet\Graylog\Processor\GraylogProcessor;
use Monolog\Formatter\FormatterInterface;
use Monolog\Formatter\GelfMessageFormatter;
use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Logger;
use Monolog\Processor\IntrospectionProcessor;
use Monolog\Processor\MemoryPeakUsageProcessor;
use Monolog\Processor\MemoryUsageProcessor;
use Monolog\Processor\WebProcessor;
use RuntimeException;

class GraylogHandler extends AbstractProcessingHandler
{
    /**
     * @var \Exolnet\Graylog\Publisher\GraylogPublisher the publisher object that sends the message to the server
     */
    protected $publisher;

    /**
     * GraylogHandler constructor.
     * @param $publisher
     * @param string $host
     * @param int $port
     * @param int $level
     * @param array $extra
     */
    public function __construct($publisher, string $host, int $port, $level = Logger::NOTICE, array $extra = [])
    {
        if (!class_exists($publisher)) {
            throw new RuntimeException(
                'Publisher class: ' . $publisher . ' does not exist!'
            );
        }

        parent::__construct($level, true);

        $this->publisher = new $publisher($host, $port);

        $this->pushProcessor(new IntrospectionProcessor());
        $this->pushProcessor(new WebProcessor());
        $this->pushProcessor(new MemoryUsageProcessor());
        $this->pushProcessor(new MemoryPeakUsageProcessor());
        $this->pushProcessor(new GraylogProcessor($extra));
    }

    /**
     * {@inheritdoc}
     */
    protected function write(array $record): void
    {
        $this->publisher->publish($record['formatted']);
    }

    /**
     * {@inheritDoc}
     */
    protected function getDefaultFormatter(): FormatterInterface
    {
        return new GelfMessageFormatter();
    }
}
