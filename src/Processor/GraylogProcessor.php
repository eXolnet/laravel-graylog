<?php

namespace Exolnet\Graylog\Processor;

class GraylogProcessor
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

    public function __invoke(array $record)
    {
        foreach ($this->config as $extraKey => $extra) {
            $record['extra'][$extraKey] = $extra;
        }

        return $record;
    }
}
