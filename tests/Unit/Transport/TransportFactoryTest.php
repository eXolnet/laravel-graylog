<?php

namespace Exolnet\Graylog\Tests\Unit\Transport;

use Exolnet\Graylog\Transport\TransportFactory;
use Gelf\Transport\HttpTransport;
use Gelf\Transport\KeepAliveRetryTransportWrapper;
use Gelf\Transport\TcpTransport;
use Gelf\Transport\UdpTransport;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Exolnet\Graylog\Transport\TransportFactory
 */
class TransportFactoryTest extends TestCase
{
    /**
     * @var \Exolnet\Graylog\Transport\TransportFactory
     */
    protected $factory;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->factory = new TransportFactory();
    }

    /**
     * @return void
     * @test
     */
    public function testInvalidTransport(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $this->factory->make('invalid', '127.0.0.1', 12001);
    }

    /**
     * @return void
     * @test
     */
    public function testMakeUdpTransport(): void
    {
        $transport = $this->factory->make('udp', '127.0.0.1', 12001);

        $this->assertInstanceOf(UdpTransport::class, $transport);
    }

    /**
     * @return void
     * @test
     */
    public function testMakeTcpTransport(): void
    {
        $transport = $this->factory->make('tcp', '127.0.0.1', 12001);

        $this->assertInstanceOf(TcpTransport::class, $transport);
    }

    /**
     * @return void
     * @test
     */
    public function testMakeSslTransport(): void
    {
        $transport = $this->factory->make('ssl', '127.0.0.1', 12001);

        $this->assertInstanceOf(TcpTransport::class, $transport);
    }

    /**
     * @return void
     * @test
     */
    public function testMakeHttpTransport(): void
    {
        $transport = $this->factory->make('http', '127.0.0.1', 12001, '/gelf');

        $this->assertInstanceOf(KeepAliveRetryTransportWrapper::class, $transport);
        $this->assertInstanceOf(HttpTransport::class, $transport->getTransport());
    }

    /**
     * @return void
     * @test
     */
    public function testMakeHttpsTransport(): void
    {
        $transport = $this->factory->make('https', '127.0.0.1', 12001, '/gelf');

        $this->assertInstanceOf(KeepAliveRetryTransportWrapper::class, $transport);
        $this->assertInstanceOf(HttpTransport::class, $transport->getTransport());
    }
}
