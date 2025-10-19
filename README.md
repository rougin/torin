# Torin

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]][link-license]
[![Build Status][ico-build]][link-build]
[![Coverage Status][ico-coverage]][link-coverage]
[![Total Downloads][ico-downloads]][link-downloads]

A simple inventory management package written in PHP.

## Installation

Clone the project using [Git](https://git-scm.com/):

``` bash
$ git clone https://github.com/rougin/torin.git "Torin"
$ cd "Torin" && rm -rf .git
```

Then use [Composer](https://getcomposer.org/) to install its dependencies:

``` bash
$ cd Torin
$ composer install
```

## Running as app

Serve with [PHP's built-in web server](https://www.php.net/manual/en/features.commandline.webserver.php):

``` bash
$ php -S localhost:80 -t .\app\public
```

Then open http://localhost in a web browser.

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more recent changes.

## Contributing

See [CONTRIBUTING](CONTRIBUTING.md) on how to contribute.

## License

The MIT License (MIT). Please see [LICENSE][link-license] for more information.

[ico-build]: https://img.shields.io/github/actions/workflow/status/rougin/torin/build.yml?style=flat-square
[ico-coverage]: https://img.shields.io/codecov/c/github/rougin/torin?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/rougin/torin.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-version]: https://img.shields.io/packagist/v/rougin/torin.svg?style=flat-square

[link-build]: https://github.com/rougin/torin/actions
[link-changelog]: https://github.com/rougin/torin/blob/master/CHANGELOG.md
[link-contributing]: https://github.com/rougin/torin/blob/master/CONTRIBUTING.md
[link-contributors]: https://github.com/rougin/torin/contributors
[link-coverage]: https://app.codecov.io/gh/rougin/torin
[link-downloads]: https://packagist.org/packages/rougin/torin
[link-license]: https://github.com/rougin/torin/blob/master/LICENSE.md
[link-packagist]: https://packagist.org/packages/rougin/torin
