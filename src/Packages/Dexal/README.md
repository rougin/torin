# Dexal

A simple utility PHP package for templates using [alpine.js](https://alpinejs.dev/).
This package also assumes that data are coming from an API, and modal-based viewing is used.

## Installation

Install the package using [Composer](https://getcomposer.org/):

``` bash
$ composer require rougin/dexal
```

## Basic usage

Use the `Depot` class to create JavaScript-based CRUD methods:

``` php
// src/Pages/Items.php

// ...

use Rougin\Dexal\Depot;
use Rougin\Gable\Pagee;

class Items
{
    public function index()
    {
        // "items" will be the variable name in the JavaScript end ---
        $data = array('depot' => new Depot('items'));
        // -----------------------------------------------------------

        // Prepare the pagination --------------------------
        $pagee = Pagee::fromRequest($request)->asAlpine();

        $link = $plate->getLinkHelper()->set('items');

        $pagee->setLink($link)->setTotal($item->getTotal());

        $data['pagee'] = $pagee;
        // -------------------------------------------------

        // ...
    }
}
```

`Pagee` from the `Gable` package may be required if there's a need to load paginated data.

## Available methods

### withInit

Creates an `init` method. It will then initialize any defined `Select` classes.

It will also call the `load` method for getting the results for the specified page:

``` html
// app/plates/items/depot.php

<script type="text/javascript">

// ...

<?= $depot->withInit($pagee->getPage()) ?>
</script>
```

### withLoad

Creates the `load` method. This is used for loading data based on `Pagee` data:

``` html
// app/plates/items/depot.php

<script type="text/javascript">

// ...

<?= $depot->withLoad($pagee)
  ->setLink($url->set('/v1/items')) ?>
</script>
```

> [!NOTE]
> This requires a `Pagee` class from the `Gable` package for pagination.

### withStore

[documentation about `withStore`]

``` html
// app/plates/items/depot.php

<script type="text/javascript">

// ...

<?= $depot->withStore()
  ->addField('name')
  ->addField('detail')
  ->setAlert('Item created!', 'Item successfully created.')
  ->setLink($url->set('/v1/items')) ?>
```

### withEdit

[documentation about `withEdit`]

``` html
// app/plates/items/depot.php

<script type="text/javascript">

// ...

<?= $depot->withEdit()
  ->addField('name')
  ->addField('detail')
  ->addField('id')
  ->showModal('item-detail-modal') ?>
</script>
```

### withUpdate

[documentation about `withUpdate`]

``` html
// app/plates/items/depot.php

<script type="text/javascript">

// ...

<?= $depot->withUpdate()
  ->addField('name')
  ->addField('detail')
  ->setAlert('Item updated!', 'Item successfully updated.')
  ->setLink($url->set('/v1/items')) ?>
</script>
```

### withTrash

[documentation about `withTrash`]

``` html
// app/plates/items/depot.php

<script type="text/javascript">

// ...

<?= $depot->withTrash()
  ->addField('name')
  ->addField('id')
  ->showModal('delete-item-modal') ?>
</script>
```

### withRemove

[documentation about `withRemove`]

``` html
// app/plates/items/depot.php

<script type="text/javascript">

// ...

<?= $depot->withUpdate()
  ->addField('name')
  ->addField('detail')
  ->setAlert('Item updated!', 'Item successfully updated.')
  ->setLink($url->set('/v1/items')) ?>
</script>
```

### withClose

[documentation about `withClose`]

``` html
// app/plates/items/depot.php

<script type="text/javascript">

// ...

<?= $depot->withClose()
  ->withScript($script)
  ->hideModal('delete-item-modal')
  ->hideModal('item-detail-modal')
  ->resetField('detail')
  ->resetField('error')
  ->resetField('id')
  ->resetField('name')
  ->resetField('loadError') ?>
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
