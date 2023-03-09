<?php

namespace Exolnet\Graylog\Processor;

use Monolog\LogRecord;
use Monolog\Processor\ProcessorInterface;

class ExtraProcessor implements ProcessorInterface
{
    /**
     * @var array|\Monolog\LogRecord
     */
    protected array|LogRecord $config;

    /**
     * @param array $config
     */
    public function __construct(array|LogRecord $config)
    {
        $this->config = $config;
    }

    /**
     * {@inheritDoc}
     */
    public function __invoke(array|LogRecord $record)
    {
        foreach ($this->config as $extraKey => $extra) {
            $record['extra'][$extraKey] = $extra;
        }

        // Remove null/false/empty values
        $record['extra'] = array_filter($record['extra']);

        return $record;
    }
}
