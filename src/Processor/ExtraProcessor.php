<?php

namespace Exolnet\Graylog\Processor;

use Monolog\Processor\ProcessorInterface;

class ExtraProcessor implements ProcessorInterface
{
    /**
     * @var array
     */
    protected $config;

    /**
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * {@inheritDoc}
     */
    public function __invoke(array $record)
    {
        foreach ($this->config as $extraKey => $extra) {
            $record['extra'][$extraKey] = $extra;
        }

        // Remove null/false/empty values
        $record['extra'] = array_filter($record['extra']);

        return $record;
    }
}
