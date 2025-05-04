# Dexal

A simple utility PHP package for templates using [alpine.js](https://alpinejs.dev/).

## Installation

Install the package using [Composer](https://getcomposer.org/):

``` bash
$ composer require rougin/dexal
```

## Basic usage

Use the `Depot` class to create CRUD methods:

``` php
// src/Pages/Items.php

// ...

use Rougin\Dexal\Depot;

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
