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
        $properties = array('id' => false, 'primary_key' => array('id'));

        $table = $this->table('item_order', $properties);

        $constraints = array('delete' => 'CASCADE', 'update' => 'CASCADE');

        $table
            ->addColumn('id', 'integer', array('limit' => 10, 'identity' => true))
            ->addColumn('item_id', 'integer', array('length' => 10))
            ->addColumn('order_id', 'integer', array('length' => 10))
            ->addColumn('quantity', 'integer', array('limit' => 10))
            ->addColumn('created_by', 'integer', array('limit' => 10, 'null' => true))
            ->addColumn('updated_by', 'integer', array('limit' => 10, 'null' => true))
            ->addColumn('deleted_by', 'integer', array('limit' => 10, 'null' => true))
            ->addColumn('created_at', 'datetime')
            ->addColumn('updated_at', 'datetime', array('null' => true))
            ->addColumn('deleted_at', 'datetime', array('null' => true))
            ->addForeignKey('item_id', 'items', 'id', $constraints)
            ->addForeignKey('order_id', 'orders', 'id', $constraints)
            ->create();
    }
}
