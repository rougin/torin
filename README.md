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

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Development

`Torin` is also configured for running unit tests with automating code quality and documentation.

### Unit tests

Running unit tests were configured for [phpunit](https://phpunit.de/index.html):

``` bash
$ composer test
```

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
