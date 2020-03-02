<?php

namespace Exolnet\Graylog;

use Exolnet\Graylog\Handler\GraylogHandler;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

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
                        'app' => Str::slug($this->app['config']->get('app.name')),
                        'env' => $this->app['config']->get('app.env'),
                        'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? null,
                    ]
                ],
            ];

            $config = array_replace_recursive($defaultConfig, $config);
            return $this->createMonologDriver($config);
        });
    }
}
