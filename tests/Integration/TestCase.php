<?php

namespace Exolnet\Graylog\Tests\Integration;

use Exolnet\Graylog\GraylogServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    /**
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            GraylogServiceProvider::class,
        ];
    }
}
