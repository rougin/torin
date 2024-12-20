# Torin

Simple inventory management.

## Installation

Clone the `Torin` project using [Git](https://git-scm.com/):

``` bash
$ git clone https://github.com/rougin/torin.git "Test"
$ cd "Test" && rm -rf .git
```

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

If there is a need to check the source code of `Torin` for development purposes (e.g., creating fixes, new features, etc.), kindly clone this repository first to a local machine:

``` bash
$ git clone https://github.com/rougin/torin.git "Torin"
```

After cloning, use `Composer` to install its required packages:

``` bash
$ cd Torin
$ composer update
```

### Unit tests

`Torin` also contains unit tests that were written in [PHPUnit](https://phpunit.de/index.html):

``` bash
$ composer test
```

It is recommended to run the above command to always check if the updated code introduces errors when creating fixes or implementing new features.

> [!NOTE]
> Please see the [official documentation](https://phpunit.de/documentation.html) of `PHPUnit` on how to write unit tests to the specified testing framework.

### Code quality

To retain the code quality of `Torin`, a static code analysis code tool named [PHPStan](https://phpstan.org/) can be used during development. To start, kindly install the specified package in the global environment of `Composer`:

``` bash
$ composer global require phpstan/phpstan --dev
```

Once installed, `PHPStan` can now be run using its namesake command:

``` bash
$ phpstan
```

> [!NOTE]
> When running `phpstan`, it will use the `phpstan.neon` file which is already provided by `Torin`.

### Coding style

Aside from code quality, `Torin` also uses a tool named [PHP Coding Standards Fixer](https://cs.symfony.com/) for maintaining an opinionated style guide. To use this tooling, it needs also to be installed in the `Composer`'s global environment first:

``` bash
$ composer global require friendsofphp/php-cs-fixer --dev
```

After its installation, kindly use the `php-cs-fixer` command in the same `Torin` directory:

``` bash
$ php-cs-fixer fix --config=phpstyle.php
```

The `phpstyle.php` file provided by `Torin` currently follows the [PSR-12](https://www.php-fig.org/psr/psr-12/) standard as its baseline for the coding style and uses [Allman](https://en.wikipedia.org/wiki/Indentation_style#Allman_style) as its indentation style.

> [!NOTE]
> Installing both `PHPStan` and `PHP Coding Standards Fixer` requires a minimum version of PHP at least `7.4`.
