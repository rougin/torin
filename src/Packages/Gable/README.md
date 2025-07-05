# Gable

A simple HTML table generator in PHP.

## Installation

Install the package using [Composer](https://getcomposer.org/):

``` bash
$ composer require rougin/gable
```

## Basic usage

Generate a HTML table using the `Table` class:

``` php
// table.php
use Rougin\Gable\Table;

$table = new Table;

$table->newColumn();
$table->setCell('Name');
$table->setCell('Age');

$table->newRow();
$table->setCell('Chad');
$table->setCell('25');

$table->newRow();
$table->setCell('Gable');
$table->setCell('25');

echo $table->make();
```

``` bash
$ php table.php
<table><thead><tr><td>Name</td><td>Age</td></tr></thead><tbody><tr><td>Chad</td><td>25</td></tr><tr><td>Gable</td><td>25</td></tr></tbody></table>
```

## Customization

Each column, row, or even cell can be customized:

``` php
// table.php
use Rougin\Gable\Table;

$table = new Table;

$table->newColumn();
$table->setCell('Name', null, null, 2);
$table->newColumn();
$table->setEmptyCell();
$table->setCell('Age');

$table->newRow();
$table->setCell('Chad', 'center', 'fw-bold');
$table->setCell('25', 'right');

$table->newRow('fw-bold');
$table->setCell('Gable', 'center', 'fw-bold');
$table->setCell('25', 'right');

echo $table->make();
```

``` bash
$ php table.php
<table><thead><tr><td colspan="2">Name</td></tr><tr><td></td><td>Age</td></tr></thead><tbody><tr><td align="center" class="fw-bold">Chad</td><td align="right">25</td></tr><tr class="fw-bold"><td align="center" class="fw-bold">Gable</td><td align="right">25</td></tr></tbody></table>
```

## Available methods

Kindly see the following optional arguments for each method from the `Table` class:

```
newColumn($class = null, $style = null, $width = null)
```
* Adds a new `<tr>` element under `<thead>`.

```
newRow($class = null, $style = null, $width = null)
```
* Adds a new `<tr>` element under `<tbody>`.

```
setCell($value, $align = null, $class = null, $cspan = null, $rspan = null, $style = null, $width = null)
```
* Adds a new `<td>` element in either `<thead>` or `<tbody>`.

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
