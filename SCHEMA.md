https://www.geeksforgeeks.org/how-to-design-database-inventory-management-systems/
https://english.stackexchange.com/questions/102247/hypernym-for-clients-members-and-partners
https://vertabelo.com/blog/data-model-for-inventory-management-system/
https://katanamrp.com/blog/ai-for-inventory-management/

clients (stakeholders)
- code
- name
- type (0 - customer, 1 - supplier)

items (products)
- parent_id
- code
- name
- detail

orders
- client_id (if null, then the owner is the client)
- code
- date_created
- type (0 - sale, 1 - purchase, 2 - transfer)
- status (0 - pending, 1 - fulfilled, 2 - cancelled)

item_order
- order_id
- item_id
- quantity

actions (transactions)
- order_id
- item_id
- type (copy value from orders.type)
- quantity
- date_created
