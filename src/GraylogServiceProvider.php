<?php

namespace Exolnet\Graylog;

use Exolnet\Graylog\Handler\GraylogHandler;
use Illuminate\Log\LogManager;
use Illuminate\Support\ServiceProvider;
use Monolog\Formatter\GelfMessageFormatter;

class GraylogServiceProvider extends ServiceProvider
{
    /**
     * Register the application services.
     */
    public function register()
    {
        $this->callAfterResolving(LogManager::class, function (LogManager $log) {
            $log->extend('graylog', function ($app, array $config) {
                $defaultConfig = [
                    'handler' => GraylogHandler::class,
                    'handler_with' => [
                        'transport' => 'udp',
                        'host' => 'localhost',
                        'port' => 12201,
                        'path' => '/gelf',
                        'extra' => [
                            //
                        ],
                    ],
                    'formatter' => GelfMessageFormatter::class,
                ];

                $config = array_replace_recursive($defaultConfig, $config);

                return $this->createMonologDriver($config);
            });
        });
    }
}
