<?php

use Phinx\Migration\AbstractMigration;

/**
 * @package Torin
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
final class CreateItemOrderTable extends AbstractMigration
{
    /**
     * @return void
     */
    public function change()
    {
        $table = $this->table('item_order');

        $keys = array('delete' => 'CASCADE', 'update' => 'CASCADE');

        $table
            ->addColumn('item_id', 'integer', array('length' => 10))
            ->addColumn('order_id', 'integer', array('length' => 10))
            ->addColumn('quantity', 'integer', array('limit' => 10))
            ->addColumn('created_by', 'integer', array('limit' => 10, 'null' => true))
            ->addColumn('updated_by', 'integer', array('limit' => 10, 'null' => true))
            ->addColumn('deleted_by', 'integer', array('limit' => 10, 'null' => true))
            ->addColumn('created_at', 'datetime')
            ->addColumn('updated_at', 'datetime', array('null' => true))
            ->addColumn('deleted_at', 'datetime', array('null' => true))
            ->addForeignKey('item_id', 'items', 'id', $keys)
            ->addForeignKey('order_id', 'orders', 'id', $keys)
            ->create();
    }
}
