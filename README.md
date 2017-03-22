# sentinel-guard

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

This package implements the `Illuminate\Contracts\Auth\StatefulGuard` interface using Sentinel.

## Install

Via Composer

``` bash
$ composer require rojtjo/sentinel-guard
```

## Usage

Configure the guard in `config/auth.php`
``` php
[
    'guards' => [
        'web' => [
            'driver' => 'sentinel',
            'provider' => 'users',
        ],
    ],
];
```

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CONDUCT](CONDUCT.md) for details.

## Security

If you discover any security related issues, please email me@rojvroemen.com instead of using the issue tracker.

## Credits

- [Roj Vroemen][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/rojtjo/sentinel-guard.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/rojtjo/sentinel-guard/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/rojtjo/sentinel-guard.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/rojtjo/sentinel-guard.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/rojtjo/sentinel-guard.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/rojtjo/sentinel-guard
[link-travis]: https://travis-ci.org/rojtjo/sentinel-guard
[link-scrutinizer]: https://scrutinizer-ci.com/g/rojtjo/sentinel-guard/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/rojtjo/sentinel-guard
[link-downloads]: https://packagist.org/packages/rojtjo/sentinel-guard
[link-author]: https://github.com/Rojtjo
[link-contributors]: ../../contributors
