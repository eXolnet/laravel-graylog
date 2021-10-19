# laravel-graylog

[![Latest Stable Version](https://poser.pugx.org/eXolnet/laravel-graylog/v/stable?format=flat-square)](https://packagist.org/packages/eXolnet/laravel-graylog)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/github/workflow/status/eXolnet/laravel-graylog/tests?label=tests&style=flat-square)](https://github.com/eXolnet/laravel-graylog/actions?query=workflow%3Atests)
[![Total Downloads](https://img.shields.io/packagist/dt/eXolnet/laravel-graylog.svg?style=flat-square)](https://packagist.org/packages/eXolnet/laravel-graylog)

This package extends Laravel’s log package to add a graylog driver.

## Installation

1. Require this package with composer:

    ```bash
    composer require exolnet/laravel-graylog
    ```

2. If you don't use package auto-discovery, add the service provider to the `providers` array in `config/app.php`:

    ```php
    Exolnet\Graylog\GraylogServiceProvider::class
    ```

3. Add a graylog channel in your `logging.php` configuration file:

    ```php
    'graylog' => [
        'driver' => 'graylog',
        'level' => 'notice',
        'handler_with' => [
            'transport' => env('LOG_GRAYLOG_TRANSPORT', 'udp'),
            'host' => env('LOG_GRAYLOG_HOST', 'localhost'),
            'port' => env('LOG_GRAYLOG_PORT', 12201),
            'path' => env('LOG_GRAYLOG_PATH', '/gelf'),
            'extra' => [
                //
            ]
        ],
    ],
    ```

4. Change your `LOG_CHANNEL` for `graylog` or add it to your stack in the `logging.php` configuration file

## Usage

### Supported Transports

The following transports are supported: `udp`, `tcp`, `ssl`, `http` and `https`. Select the transport accordingly to
your Graylog set up using the `GRAYLOG_TRANSPORT` configuration. By default, the `udp` transport is used.

The default path for `http` and `https` transports is `/gelf`. This value can be configured using the `GRAYLOG_PATH`
configuration.

```
GRAYLOG_PATH=/gelf
```

## Testing

To run the phpUnit tests, please use:

```bash
composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CODE OF CONDUCT](CODE_OF_CONDUCT.md) for details.

## Security

If you discover any security related issues, please email security@exolnet.com instead of using the issue tracker.

## Credits

- [Simon Gaudreau](https://github.com/Gandhi11)
- [Pat Gagnon-Renaud](https://github.com/pgrenaud)
- [Alexandre D'Eschambeault](https://github.com/xel1045)
- [All Contributors](../../contributors)

## License

This code is licensed under the [MIT license](http://choosealicense.com/licenses/mit/). 
Please see the [license file](LICENSE) for more information.
