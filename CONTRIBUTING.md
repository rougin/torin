# Contributing

To ensure a smooth and effective collaboration, kindly follow the guidelines below.

## Submit an issue

Before working on a new feature, bug fix, or any other change, the contributor must create first an issue to discuss the proposed change. This helps to:

* Prevent duplicated work;
* Ensure the change aligns with the project's goals; and
* Get early feedback from the maintainers.

### Example issue title

```
Error when running the route
```

## Creating pull requests

Once the issue has been discussed and approved by a maintainer, the contributor can proceed with development.

* **Reference the issue** - when creating the pull request, the contributor must always reference the related issue number in the title and description of the Pull Request (PR).
* **Keep it focused** - the PR should ideally address only one issue.

### Example pull request title

```
#1 - Fix for running the route
```

## Coding standards

During the development of a pull request, the contributor should ensure that the code adheres to the project's quality and style standards.

### Code quality

Use [phpstan](https://phpstan.org/) for checking potential bugs, logical errors, and general code quality issues:

``` bash
$ phpstan
```

### Coding style

Use [php-cs-fixer](https://cs.symfony.com/) to automatically fix coding standards issues:

``` bash
$ php-cs-fixer fix --config=phpstyle.php
```

### Unit tests

Use [phpunit](https://phpunit.de/index.html) for creating and running automated test:

``` bash
$ composer test
```

## Automated tests

It is strongly encouraged to create automated tests when creating new features or fixing bugs.

* **New features** - new features should be accompanied by appropriate unit or functional tests using `phpunit` to cover the new functionality.
* **Bug fixes** - bug fixes should include a new failing test that demonstrates the bug and then passes once the fix is implemented. This helps prevent regressions.
