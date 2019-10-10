<?php

namespace Exolnet\Skeleton\Tests\Unit;

use Mockery;
use PHPUnit\Framework\TestCase;

abstract class UnitTest extends TestCase
{
    public function tearDown()
    {
        Mockery::close();
    }
}
