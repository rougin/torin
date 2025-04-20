# Project overview
You are building a simple inventory management system, where users can manage items (products), clients (customers, suppliers), and orders (sales, purchases).

# Technology stack
* Alpine.js (https://alpinejs.dev/)
* Bootstrap 5 (https://getbootstrap.com/)
* Bootstrap Icons (https://icons.getbootstrap.com/)
* CSS (https://css-tricks.com/)
* HTML (https://html.com/)
* JavaScript (https://www.javascript.com/)
* Laravel Eloquent (https://laravel.com/docs/12.x/eloquent)
* Phinx (https://book.cakephp.org/phinx/0/en/index.html)
* PHP (https://www.php.net/)

# Core functionalities
1. Create, read, update, and delete items.
2. Create, read, update, and delete clients.
3. Create, read, update, and delete orders.

# Database schema
* `clients` table
  - `id` - the primary key, must be unique and not nullable.
  - `parent_id` - if not empty, it means that it is attached to another client.
  - `type` - the category of a client:
    `0` - the client is a customer.
    `1` - the client is a supplier.
  - `code` - the unique client code. Should be in this format: `01-20241215-00001`.
    `01` - based on the `type` column.
    `20241215` - current date the client is created (uses `Ymd` format in PHP).
    `00001` - total of clients + 1. `00001` means it is the first client created.
* `items` table
  - `id` - the primary key, must be unique and not nullable.
  - `parent_id` - if not empty, it means that it is attached to another item.
  - `code` - the unique item code. Should be in this format: `00-20241215-00001`.
    `00` - no bearing, but might be updated in the future.
    `20241215` - current date the item is created (uses `Ymd` format in PHP).
    `00001` - total of items + 1. `00001` means it is the first item created.
* `orders` table
  - `id` - the primary key, must be unique and not nullable.
  - `client_id` - assigned client from `clients`.
  - `type` - the category of an order:
    `0` - the order is a sale.
    `1` - the order is a purchase.
    `2` - the order is a transfer. Used for transferring stock without sales nor purchases.
  - `status` - current status of an order:
    `0` - the order is still pending. Requires to be delivered or purchased to the client.
    `1` - the order is completed. The `quantity` from `item_order` database table will now be used as existing quantity to attached item.
    `3` - the order is cancelled. The client or the user cancelled the order.
  - `code` - the unique client code. Should be in this format: `1-20250419-00001`.
    `01` - based on the `type` column.
    `20241215` - current date the order is created (uses `Ymd` format in PHP).
    `00001` - total of orders + 1. `00001` means it is the first order created.
  - `remarks` - additional information in the order.
* `item_order` table
  - `id` - the primary key, must be unique and not nullable.
  - `item_id` - assigned item from `items`.
  - `order_id` - assigned order from `orders`.
  - `quantity` - number of quantity of an item from the order.

# File structure
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

# Entry point and execution flow
1. Entry point of the project is `app/public/index.php`.
2. Prior in running the project, Composer is autoloaded first.
3. The `System` class is loaded to get the packages to be used.
  * The list of packages to be loaded are found in `packages` field in `app/config/app.php`.
4. One of the packages to be loaded is the `Package` class.
  * This also loads the `Plates` and `Router` classes.
5. `System` class will now get the received URI (e.g., `/hello-world`).
6. The received URI will be checked in `Plates` and `Router` classes.
7. If found, the specified route class will be called from `Pages` or `Routes` folder.

# Coding style
1. Strictly conform to the [PSR-12](https://www.php-fig.org/psr/psr-12/) standard.
2. For brackets, use the [Allman indentation style](https://en.wikipedia.org/wiki/Indentation_style#Allman).
3. Use [php-cs-fixer](https://cs.symfony.com/) and read `phpstyle.php` for the its rules.
4. Always use one word for variables (e.g., `$userAddress` to `$address`).
5. There is no `<?php` or `php` code line when creating templates in `app/plates`.
6. Use 2 spacing when creating files in `app/plates`. Retain 4 spacing in other folders.

# Notes and considerations
1. Do not hallucinate, always check the project's source code to get examples.
2. Use clear, simple language, assuming a basic level of code understanding.
3. Scan the `vendor` directory for files and use them as reference for code generation.
4. Design implementations that conforms to [SOLID principles](https://en.wikipedia.org/wiki/SOLID).
5. Use coding style and design patterns on PHP 5.3 (`array()` instead of `[]`).
6. For class properties that are using arrays, use brackets (`[]`) instead.

# Strategies
1. When creating modal templates, always add them first in `index.php` of the plate folder:
  ```
  <?= $plate->add('[FOLDER].[NAME]', compact('form')) ?>
  ```

# Code templates

Strictly adhere to the following structures when generating code:

* For creating modals in general:
```
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

* For creating modals for deletion:
```
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
