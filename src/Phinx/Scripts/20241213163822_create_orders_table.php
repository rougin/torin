<?php

use Phinx\Migration\AbstractMigration;

/**
 * @package Torin
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
final class CreateOrdersTable extends AbstractMigration
{
    /**
     * @return void
     */
    public function change()
    {
        $properties = array('id' => false, 'primary_key' => array('id'));

        $table = $this->table('orders', $properties);

        $constraints = array('delete' => 'CASCADE', 'update' => 'CASCADE');

        $table
            ->addColumn('id', 'integer', array('limit' => 10, 'identity' => true))
            ->addColumn('client_id', 'integer', array('length' => 10, 'null' => true))
            ->addColumn('type', 'integer', array('limit' => 1))
            ->addColumn('status', 'integer', array('limit' => 1, 'default' => 0))
            ->addColumn('code', 'string', array('limit' => 100, 'null' => true))
            ->addColumn('remarks', 'string', array('limit' => 300, 'null' => true))
            ->addColumn('created_by', 'integer', array('limit' => 10, 'null' => true))
            ->addColumn('updated_by', 'integer', array('limit' => 10, 'null' => true))
            ->addColumn('deleted_by', 'integer', array('limit' => 10, 'null' => true))
            ->addColumn('created_at', 'datetime')
            ->addColumn('updated_at', 'datetime', array('null' => true))
            ->addColumn('deleted_at', 'datetime', array('null' => true))
            ->addForeignKey('client_id', 'clients', 'id', $constraints)
            ->create();
    }
}
