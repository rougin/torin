<?php

use Phinx\Migration\AbstractMigration;

final class CreateItemsTable extends AbstractMigration
{
    /**
     * @return void
     */
    public function change(): void
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
