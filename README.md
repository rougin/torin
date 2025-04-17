# Torin

Simple inventory management.

## Installation

Clone the `Torin` project using [Git](https://git-scm.com/):

``` bash
$ git clone https://github.com/rougin/torin.git "Torin"
$ cd "Torin" && rm -rf .git
```

Once downloaded, use `Composer` to install its required packages:

``` bash
$ cd Torin
$ composer update
```

## Running as an app

Running `Torin` as an app requires the [PHP's web server](https://www.php.net/manual/en/features.commandline.webserver.php):

``` bash
$ php -S localhost:80 -t .\app\public
```

Then open a web browser with the URL to http://localhost.

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Development

`Torin` is also configured for running unit tests with automating code quality and documentation.

### Code quality

`Torin` uses [phpstan](https://phpstan.org/) for maintaining its code quality:

``` bash
$ phpstan
```

### Coding style

Maintaining its coding style requires [php-cs-fixer](https://cs.symfony.com/):

``` bash
$ php-cs-fixer fix --config=phpstyle.php
```

### Unit tests

Running unit tests were configured for [phpunit](https://phpunit.de/index.html):

``` bash
$ composer test
```
