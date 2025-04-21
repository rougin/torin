# Project overview
You are building a simple inventory management system, where users can manage items (products), clients (customers, suppliers), and orders (sales, purchases).

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
