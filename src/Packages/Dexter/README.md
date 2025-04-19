# Dexterity

A simple utility PHP package for handling front-end related code using [alpine.js](https://alpinejs.dev/).

## Installation

Install the `Dexterity` package via [Composer](https://getcomposer.org/):

``` bash
$ composer require rougin/dexterity
```

## Basic usage

Use the `Depot` class to create CRUD methods:

``` php
// src/Pages/Items.php

// ...

use Rougin\Dexter\Alpine\Depot;

class Items
{
    public function index()
    {
        $depot = new Depot('items');

        // ...

        $data = array('depot' => $depot);

        // ...
    }
}
```

``` html
// app/plates/items/depot.php

<script type="text/javascript">

// ...

<?= $depot->withInit($pagee->getPage()) ?>
</script>
```

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Development

`Dexterity` is also configured for running unit tests with automating code quality and documentation.

### Code quality

`Dexterity` uses [phpstan](https://phpstan.org/) for maintaining its code quality:

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
