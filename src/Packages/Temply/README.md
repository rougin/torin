# Temply

A collection of simple template helpers for PHP

## Installation

Install the package using [Composer](https://getcomposer.org/):

``` bash
$ composer require rougin/temply
```

## Basic usage

Use the `FormHelper` to create form-related HTML (e.g., `<input>`, `<button>`):

``` php
use Rougin\Temply\Helpers\FormHelper;

$form = new FormHelper;

echo $form->label('Name', 'form-label mb-0')->asRequired();
echo $form->input('name', 'form-control')->asModel()->disablesOn('loading');
echo $form->error('error.name');
```

``` html
<div class="mb-3">
  <label class="form-label mb-0">Name <span class="text-danger">*</span></label>
  <input type="text" name="name" class="form-control" x-model="name" :disabled="loading">
  <template x-if="error.name">
    <p class="text-danger small mb-0" x-text="error.name[0]"></p>
  </template>
</div>
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
