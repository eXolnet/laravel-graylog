<?php

namespace Exolnet\Graylog\Transport;

use Gelf\Transport\AbstractTransport;
use Gelf\Transport\HttpTransport;
use Gelf\Transport\SslOptions;
use Gelf\Transport\TcpTransport;
use Gelf\Transport\UdpTransport;
use InvalidArgumentException;

class TransportFactory
{
    /**
     * @param string $transport
     * @param string $host
     * @param int $port
     * @param string|null $path
     * @return \Gelf\Transport\AbstractTransport
     */
    public function make(string $transport, string $host, int $port, ?string $path = null): AbstractTransport
    {
        if ($transport === 'udp') {
            return $this->makeUdpTransport($host, $port);
        }

        if ($transport === 'tcp') {
            return $this->makeTcpTransport($host, $port);
        }

        if ($transport === 'ssl') {
            return $this->makeSslTransport($host, $port);
        }

        if ($transport === 'http') {
            return $this->makeHttpTransport($host, $port, $path);
        }

        if ($transport === 'https') {
            return $this->makeHttpsTransport($host, $port, $path);
        }

        throw new InvalidArgumentException("Transport [{$transport}] is not supported.");
    }

    /**
     * @param string $host
     * @param int|null $port
     * @return \Gelf\Transport\UdpTransport
     */
    protected static function makeUdpTransport(string $host, int $port): UdpTransport
    {
        return new UdpTransport($host, $port);
    }

    /**
     * @param string $host
     * @param int|null $port
     * @return \Gelf\Transport\TcpTransport
     */
    protected static function makeTcpTransport(string $host, int $port): TcpTransport
    {
        return new TcpTransport($host, $port);
    }

    /**
     * @param string $host
     * @param int|null $port
     * @return \Gelf\Transport\TcpTransport
     */
    protected static function makeSslTransport(string $host, int $port): TcpTransport
    {
        return new TcpTransport($host, $port, new SslOptions());
    }

    /**
     * @param string $host
     * @param int|null $port
     * @param string|null $path
     * @return \Gelf\Transport\HttpTransport
     */
    protected static function makeHttpTransport(string $host, int $port, ?string $path): HttpTransport
    {
        return new HttpTransport($host, $port, $path ?? HttpTransport::DEFAULT_PATH);
    }

    /**
     * @param string $host
     * @param int|null $port
     * @param string|null $path
     * @return \Gelf\Transport\HttpTransport
     */
    protected static function makeHttpsTransport(string $host, int $port, ?string $path): HttpTransport
    {
        return new HttpTransport($host, $port, $path ?? HttpTransport::DEFAULT_PATH, new SslOptions());
    }
}
