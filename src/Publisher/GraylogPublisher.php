<?php

namespace Exolnet\Graylog\Publisher;

use Gelf\Publisher;
use Gelf\Transport\UdpTransport;

class GraylogPublisher extends Publisher
{

    /**
     * GraylogPublisher constructor.
     * @param string $host
     * @param int $port
     */
    public function __construct(string $host, int $port)
    {
        $transport = new UdpTransport(
            $host,
            $port,
            UdpTransport::CHUNK_SIZE_LAN
        );

        parent::__construct($transport);
    }
}
