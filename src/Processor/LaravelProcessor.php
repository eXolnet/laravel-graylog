<?php

namespace Exolnet\Graylog\Processor;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;
use Monolog\Processor\ProcessorInterface;

class LaravelProcessor implements ProcessorInterface
{
    /**
     * {@inheritDoc}
     */
    public function __invoke(array $record)
    {
        $record['extra']['level_name'] = $record['level_name'];
        $record['extra']['app'] = Str::slug(Config::get('app.name'));
        $record['extra']['env'] = App::environment();
        $record['extra']['user_agent'] = Request::server('HTTP_USER_AGENT');

        return $record;
    }
}
