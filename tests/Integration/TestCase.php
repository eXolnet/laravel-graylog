<?php

namespace Exolnet\Skeleton\Tests\Integration;

use Exolnet\Skeleton\SkeletonServiceProvider;
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
            SkeletonServiceProvider::class,
        ];
    }
}
