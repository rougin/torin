<?php

use Phinx\Migration\AbstractMigration;

/**
 * @package Torin
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
final class CreateClientsTable extends AbstractMigration
{
    /**
     * @return void
     */
    public function change()
    {
        $table = $this->table('clients');

        $table
            ->addColumn('parent_id', 'integer', array('limit' => 10, 'null' => true))
            ->addColumn('type', 'integer', array('limit' => 1))
            ->addColumn('code', 'string', array('limit' => 100, 'null' => true))
            ->addColumn('name', 'string', array('limit' => 200, 'null' => true))
            ->addColumn('remarks', 'string', array('limit' => 300, 'null' => true))
            ->addColumn('created_by', 'integer', array('limit' => 10, 'null' => true))
            ->addColumn('updated_by', 'integer', array('limit' => 10, 'null' => true))
            ->addColumn('deleted_by', 'integer', array('limit' => 10, 'null' => true))
            ->addColumn('created_at', 'datetime')
            ->addColumn('updated_at', 'datetime', array('null' => true))
            ->addColumn('deleted_at', 'datetime', array('null' => true))
            ->create();
    }
}
