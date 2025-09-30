# Contributing

To ensure a smooth and effective collaboration, kindly follow the guidelines below.

## Issues

* **Open an issue first** - before working on a change, create an issue to discuss it.
> [!NOTE]
> This prevents duplicated work and ensures the change aligns with the project's goals.

* **Example issue title** - `Error when running the route`

## Pull requests

- **Reference the issue** - create a pull request once the issue is approved. Its title must reference the issue number (e.g., `#1 - Fix for running the route`).
- **Keep it focused** - each PR should address only one issue.

## Workflow

Code must adhere to the project's standards before submitting.

* **Automated tests** - new features and bug fixes must include `phpunit` tests.
```bash
$ composer test
```

> [!NOTE]
> Bug fixes should add a test that fails without the fix.

* **Code quality** - check for potential bugs and errors with `phpstan`.
```bash
$ composer analyze
```

* **Coding style** - automatically format code with `php-cs-fixer`.
```bash
$ composer restyle
```
