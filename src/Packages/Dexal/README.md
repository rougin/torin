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

Creates an `init` JavaScript method. This method initializes any defined `Select` elements using the `TomSelect` JavaScript library. After initialization, it calls the `load` method, typically with the initial page number to fetch data:

``` html
// app/plates/items/depot.php

<script type="text/javascript">

// ...

<?= $depot->withInit($pagee->getPage()) ?>
</script>
```

### withLoad

Creates the `load` JavaScript method. This method fetches paginated data from a specified API endpoint using an `Axios` GET request. It takes a `Pagee` object from the `Gable` package, constructs a query string with pagination parameters, and sends the request. Upon receiving a response, it updates the component's `items` data property with the fetched data and the `pagee` data property with pagination details (limit, pages, total). It also manages the `loading` state during the request and sets the `loadError` state on failure:

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

Creates a `store` method. This is used for sending a `POST` request to the specified link to create a new item. It collects data from the defined fields, and shows an alert upon successful creation before reloading the data:

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

Creates an `edit` JavaScript method. This method is used to populate a modal with the data of a selected item. It takes an `item` object as a parameter and assigns its properties to the corresponding fields in the modal. It can also show or hide other modals:

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

Creates an `update` JavaScript method. This method is used for sending a `PUT` request to the specified link to update an existing item. It collects data from the defined fields, includes the item's ID in the request, and shows an alert upon successful update before reloading the data:

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

Creates a `trash` JavaScript method. This method is used to populate a modal for confirming the deletion of an item. It takes an `item` object as a parameter and assigns its properties to the corresponding fields in the modal. It can also show or hide other modals:

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

Creates a `remove` JavaScript method. This method is used for sending a `DELETE` request to the specified link to remove an item. It takes the item's ID as a parameter, includes it in the request, and shows an alert upon successful deletion before reloading the data:

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

Creates a `close` JavaScript method. This method is used to close modals and reset the values of specified fields. It can also hide other modals and reset fields based on a provided script:

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
