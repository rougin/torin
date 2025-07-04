# Valdi

A simple validation package based on [Valitron](https://github.com/vlucas/valitron).

## Installation

Install the package using [Composer](https://getcomposer.org/):

``` bash
$ composer require rougin/valdi
```

## Basic usage

Create a class that extends to `Check` class:

``` php
use Rougin\Valdi\Check;

class UserCheck extends Check
{
    protected $labels =
    [
        'age' => 'Age',
        'email' => 'Email',
        'name' => 'Name',
    ];

    protected $rules =
    [
        'age' => 'required|numeric',
        'email' => 'required|email',
        'name' => 'required',
    ];
}
```

Once created, submit the data to the said class for validation:

``` php
$check = new UserCheck;

$data = /* e.g., data from request */;

if ($check->valid($data))
{
    // $data passed from validation
}
else
{
    // Get the available errors ---
    $errors = $check->errors();
    // ----------------------------

    // Or get the first error only ---
    echo $check->firstError();
    // -------------------------------
}
```

**NOTE**: Custom conditions for labels and rules is possible using the `labels` and `rules` methods:

``` php
use Rougin\Valdi\Check;

class UserCheck extends Check
{
    public function labels()
    {
        // Add conditions to custom labels here ---
        // ----------------------------------------

        return $this->labels;
    }

    public function rules($data)
    {
        // Add conditions to custom rules here ---
        // ---------------------------------------

        return $this->rules;
    }
}
```

If using data from `psr/http-message`, kindly use the `Request` class instead and add aliases under `alias` if necessary:

``` php
use Rougin\Valdi\Request;

class UserCheck extends Request
{
    protected $alias =
    [
        'name' => 'username',
        'email' => 'email_add',
        'age' => 'new_age',
    ];
}
```

``` php
$check = new UserCheck;

// Should return ServerRequestInterface ---
$request = Http::getServerRequest();
// ----------------------------------------

// Checks against data from "getQueryParams" ---
if ($check->isParamsValid($request))
{
}
// ---------------------------------------------

// Checks against data from "getParsedBody" ---
if ($check->isParsedValid($request))
{
}
// --------------------------------------------
```

When extending from the `Request` class, kindly add the `setAlias` method when overriding the `valid` method to apply the aliases defined in the specified class:

``` php
use Rougin\Valdi\Check;

class UserCheck extends Request
{
    // ...

    public function valid($data = null)
    {
        // Always include if has aliases defined ---
        $data = $this->setAlias($data);
        // -----------------------------------------

        $valid = parent::valid($data);

        if (! $valid) return $valid;

        // Add extra conditions here ---
        // -----------------------------

        return count($this->errors) === 0;
    }
}
```

**NOTE**: If an alias is specified, the aliases will be used in searching for the said fields from `ServerRequestInterface`.

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
