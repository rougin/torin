# Purpose
* Your purpose is to help me with tasks like writing code, fixing code, and understanding code.
* I will share my goals and projects with you, and you will assist me in crafting the code I need.
* Always follow the prescribed instructions below with context awareness.
* Read the details in `project.md` for more information of the project.

# Technology stack
* Always consider the following technologies below:
  - Alpine.js (https://alpinejs.dev/)
  - Bootstrap 5 (https://getbootstrap.com/)
  - Bootstrap Icons (https://icons.getbootstrap.com/)
  - CSS (https://css-tricks.com/)
  - Dexterity (https://github.com/rougin/dexterity)
  - HTML (https://html.com/)
  - JavaScript (https://www.javascript.com/)
  - Laravel Eloquent (https://laravel.com/docs/12.x/eloquent)
  - Phinx (https://book.cakephp.org/phinx/0/en/index.html)
  - PHP (https://www.php.net/)
  - Slytherin (https://github.com/rougin/slytherin)
  - Valitron (https://github.com/vlucas/valitron)
* Never use any third-party packages unless required.
* The stack uses `Slytherin` as the micro-framework.
* Pure PHP must be encouraged in all implementations.
* This project also uses `Front Controller` pattern.

# File structure
* See the file structure below for the project:
  ```
  .
  ├── app - hosts the project-specific files (e.g., configuration, templates)
  │   ├── assets - contains PHP-based JavaScript functionalities
  │   ├── config - includes configuration files (e.g., project-specific config, database connection)
  │   ├── plates - resides the templates to the project
  │   └── public - the front-controller of the project
  ├── src - contains the core source code of the project
  │   ├── Checks - provides validation logic to the entire project
  │   ├── Depots - acts as a layer between the database and the business logic
  │   ├── Models - contains Eloquent models, mostly used as constructors in depots
  │   ├── Packages - hosts the third-party packages
  │   ├── Pages - hosts the HTTP routes for the template pages
  │   ├── Phinx - contains the database migrations using Phinx
  │   ├── Routes - hosts the HTTP routes for the API endpoints
  ├── tests - contains unit tests for the project
  ```
* For template files, the following folders are used exclusively:
  ```
  .
  ├── app - hosts the project-specific files (e.g., configuration, templates)
  │   ├── assets - contains PHP-based JavaScript functionalities
  │   ├── plates - resides the templates to the project
  ├── src - contains the core source code of the project
  │   ├── Packages - hosts the third-party packages
  │   ├── Pages - hosts the HTTP routes for the template pages
  ```
* The rest of the other folders are used for RESTful APIs.

# Entry point and execution flow
1. Each incoming HTTP request goes to `app/public/index.php`.
2. Once received, `Composer` is autoloaded first.
3. The `System` class will be loaded to load the packages.
4. The packages for loading are found in `packages` field of `app/config/app.php`.
5. One of the packages to be loaded is the `Package` class.
6. The `Package` class also loads the `Plates` and `Router` classes.
5. The `System` class will now get the received URI (e.g., `/hello-world`).
6. The received URI will be checked against `Plates` and `Router`.
7. If found, the class in `Pages` or `Routes` will be called.

# Coding style
1. Use coding style and design patterns on PHP 5.3 (`array()` instead of `[]`).
2. Strictly conform to the PSR-12 standard.
3. Ensure that class names are descriptive and concise, without unnecessary suffixes like `Page`, `Route`, `Depot`, etc. (e.g., use `Users` instead of `UserRoutes` and `Users` instead of `UserPage`). Focus on the core entity or functionality the class represents.
4. For curly brackets, strictly use the Allman indentation style:
  ``` php
  if ($allowed)
  { // Curly brackets always in new line
    // ...
  }
  ```
5. Use [php-cs-fixer](https://cs.symfony.com/) and read `phpstyle.php` for the its rules.
6. Use one word for variables (e.g., `$userAddress` to `$address`).
7. Do not include `<?php` and `php` at the beginning of template files in the `app/plates`.
8. For class properties that are using arrays, use brackets (`[]`) instead:
  ``` php
  class Sample
  {
      protected $names =
      [ // Always use square brackets and in new line
          'Gryffindor',
          'Hufflepuff',
          'Ravenclaw',
          'Slytherin',
      ];
  }
  ```
9. Use 2 spacing when creating templates in `app/plates`.
10. Always use guarded `if` statements. Avoid using else statements whenever possible. Handle the negative or empty conditions first using an `if` statement with a `return`, `continue`, or a simple output, and then proceed with the main logic outside of that `if` block.
11. Never use the `Plates` template engine for generating views. All template files within the `app/plates` directory must be written using pure PHP.

# Notes and considerations
1. Always design implementations that conforms to SOLID principles.
2. Do not hallucinate, always check the source code to get examples.
3. Scan the `vendor` directory for files and use them as reference for code generation.
4. Strictly adhere to code structures found in `Code templates`.
5. Use clear, simple language, assuming a basic level of code understanding.

# Code templates
* For creating modals in general
``` html
<div class="modal fade" id="[NAME]-modal" data-bs-backdrop="static" tabindex="-1">
<div class="modal-dialog modal-dialog-centered">
  <div class="modal-content">
    <div class="modal-header text-white border-bottom-0" :class="{ 'bg-primary': id, 'bg-secondary': !id }">
      <div class="modal-title fs-5 fw-bold" id="[NAME]-modal-label">[TITLE]</div>
    </div>
    <div class="modal-body">
      [CONTENT]
    </div>
    <div class="modal-footer border-top-0 bg-light">
      <div class="me-auto">
        <div class="spinner-border align-middle" :class="{ 'text-primary': id, 'text-secondary': !id }" role="status" x-show="loading">
          <span class="visually-hidden">Loading...</span>
        </div>
      </div>
      <?= $form->button('Cancel', 'btn btn-link text-secondary text-decoration-none')->with('@click', 'close')->disablesOn('loading') ?>
      <?= $form->button('[SAVE BUTTON]', 'btn btn-secondary')->onClick('store')->disablesOn('loading') ?>
    </div>
  </div>
</div>
</div>
```
* For creating modals for deletion
``` html
<div class="modal fade" id="delete-[NAME]-modal" data-bs-backdrop="static" tabindex="-1">
<div class="modal-dialog modal-dialog-centered">
  <div class="modal-content">
    <div class="modal-header text-white bg-danger border-bottom-0">
      <div class="modal-title fs-5 fw-bold" id="[NAME]-modal-label">Delete [NAME]?</div>
    </div>
    <div class="modal-body">
      <p>Are you sure that you want to delete the [NAME] <span class="fw-bold" x-text="name"></span>?</p>
      <?= $form->error('error.delete') ?>
    </div>
    <div class="modal-footer border-top-0 bg-light">
      <div class="me-auto">
        <div class="spinner-border align-middle text-danger" role="status" x-show="loading">
          <span class="visually-hidden">Loading...</span>
        </div>
      </div>
      <?= $form->button('Cancel', 'btn btn-link text-secondary text-decoration-none')->with('@click', 'close')->disablesOn('loading') ?>
      <?= $form->button('Delete', 'btn btn-danger')->onClick('remove(id)')->disablesOn('loading') ?>
    </div>
  </div>
</div>
</div>
```
* For input fields
``` html
<div class="mb-3">
  <?= $form->label('[NAME]', 'form-label mb-0')->asRequired() ?>
  <?= $form->input('[NAME]', 'form-control')->asModel()->disablesOn('loading') ?>
  <?= $form->error('error.[NAME]') ?>
</div>
```
* For form buttons
``` html
<?= $form->button('[ACTION]')->withClass('btn btn-secondary')->disablesOn('loading') ?>
```
* Sections of an HTTP route
``` php
/**
 * @param \Rougin\Torin\Depots\ItemDepot           $item
 * @param \Psr\Http\Message\ServerRequestInterface $request
 *
 * @return \Psr\Http\Message\ResponseInterface
 */
public function index(ItemDepot $item, ServerRequestInterface $request)
{
    // Validation goes here (e.g., ItemCheck)

    // Processing of data goes here (e.g., ItemDepot)

    return /* Returning the response */;
}
```
* Anatomy of a simple class
``` php
namespace /*[NAMESPACE]*/; // Always refer to the file structure (e.g., Rougin\Torin\Routes)

/**
 * @package [PROJECT NAME]
 *
 * @author [AUTHOR] <[AUTHOR_EMAIL]>
 */
class Sample
{
    public function hello()
    {
        return 'Hello world!';
    }
}
```
* Phinx migration file
``` php
use Phinx\Migration\AbstractMigration;

/**
 * @package [PROJECT NAME]
 *
 * @author [AUTHOR] <[AUTHOR_EMAIL]>
 */
final class CreateItemsTable extends AbstractMigration
{
    /**
     * @return void
     */
    public function change()
    {
        $properties = array('id' => false, 'primary_key' => array('id'));

        $table = $this->table('items', $properties);

        $table
            ->addColumn('id', 'integer', array('limit' => 10, 'identity' => true))
            ->addColumn('parent_id', 'integer', array('limit' => 10, 'null' => true))
            ->addColumn('code', 'string', array('limit' => 100, 'null' => true))
            ->addColumn('name', 'string', array('limit' => 200, 'null' => true))
            ->addColumn('detail', 'string', array('limit' => 300, 'null' => true))
            ->addColumn('created_by', 'integer', array('limit' => 10, 'null' => true))
            ->addColumn('updated_by', 'integer', array('limit' => 10, 'null' => true))
            ->addColumn('deleted_by', 'integer', array('limit' => 10, 'null' => true))
            ->addColumn('created_at', 'datetime')
            ->addColumn('updated_at', 'datetime', array('null' => true))
            ->addColumn('deleted_at', 'datetime', array('null' => true))
            ->create();
    }
}
```
