<?php

namespace Exolnet\Graylog\Tests\Feature\Processor;

use Exolnet\Graylog\Processor\ExtraProcessor;
use Exolnet\Graylog\Tests\Feature\TestCase;

/**
 * @see \Exolnet\Graylog\Processor\ExtraProcessor
 */
class ExtraProcessorTest extends TestCase
{
    /**
     * @return void
     * @test
     */
    public function testInvoke(): void
    {
        $processor = new ExtraProcessor([
            'foo' => 'bar',
            'baz' => 'biz',
            'buzz' => null,
        ]);

        $record = $processor([]);

        $this->assertArrayHasKey('extra', $record);
        $this->assertEquals(
            [
                'foo' => 'bar',
                'baz' => 'biz',
            ],
            $record['extra']
        );
    }
}
