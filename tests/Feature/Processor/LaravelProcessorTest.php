<?php

namespace Exolnet\Graylog\Tests\Feature\Processor;

use Exolnet\Graylog\Processor\LaravelProcessor;
use Exolnet\Graylog\Tests\Feature\TestCase;

/**
 * @see \Exolnet\Graylog\Processor\LaravelProcessor
 */
class LaravelProcessorTest extends TestCase
{
    /**
     * @return void
     */
    public function testInvoke(): void
    {
        $processor = new LaravelProcessor();

        $record = $processor([
            'level_name' => 'ERROR',
        ]);

        $this->assertArrayHasKey('extra', $record);
        $this->assertEquals(
            [
                'level_name' => 'ERROR',
                'app' => 'laravel',
                'env' => 'testing',
                'user_agent' => 'Symfony',
            ],
            $record['extra']
        );
    }
}
