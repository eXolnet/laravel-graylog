<?php

namespace Exolnet\Graylog;

use Exolnet\Graylog\Handler\GraylogHandler;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Monolog\Formatter\GelfMessageFormatter;

class GraylogServiceProvider extends ServiceProvider
{
    /**
     * Register the application services.
     */
    public function register()
    {
        Log::extend('graylog', function ($app, array $config) {
            $defaultConfig = [
                'handler' => GraylogHandler::class,
                'handler_with' => [
                    'host' => 'localhost',
                    'port' => 12201,
                    'extra' => [
                        //
                    ],
                ],
                'formatter' => GelfMessageFormatter::class,
            ];

            $config = array_replace_recursive($defaultConfig, $config);

            return $this->createMonologDriver($config);
        });
    }
}
