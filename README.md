# Torin

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

See [CHANGELOG](CHANGELOG.md) for more recent changes.

## Development

Includes tools for code quality, coding style, and unit tests.

### Code quality

Analyze code quality using [phpstan](https://phpstan.org/):

``` bash
$ phpstan
```

### Coding style

Enforce coding style using [php-cs-fixer](https://cs.symfony.com/):

``` bash
$ php-cs-fixer fix --config=phpstyle.php
```

### Unit tests

Execute unit tests using [phpunit](https://phpunit.de/index.html):

``` bash
$ composer test
```
