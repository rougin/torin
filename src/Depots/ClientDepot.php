<?php

namespace Rougin\Torin\Depots;

use Rougin\Dexter\Depots\EloquentDepot;
use Rougin\Torin\Models\Client;

/**
 * @method \Rougin\Torin\Models\Client find(integer $id)
 *
 * @package Torin
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class ClientDepot extends EloquentDepot
{
    /**
     * @var \Rougin\Torin\Models\Client
     */
    protected $model;

    /**
     * @param \Rougin\Torin\Models\Client $client
     */
    public function __construct(Client $client)
    {
        $this->model = $client;
    }

    /**
     * Returns all items.
     *
     * @return \Rougin\Torin\Models\Client[]
     */
    public function all()
    {
        return $this->model->all();
    }

    /**
     * @param array<string, mixed> $data
     *
     * @return \Rougin\Torin\Models\Client
     */
    public function create($data)
    {
        $data['code'] = $this->getCode();

        return $this->model->create($data);
    }

    /**
     * @return array<string, mixed>[]
     */
    public function getSelect()
    {
        $items = $this->model->all();

        $output = array();

        foreach ($items as $item)
        {
            $row = array();

            $row['value'] = $item->id;

            $row['label'] = $item->name;

            $output[] = $row;
        }

        return $output;
    }

    /**
     * @param integer              $id
     * @param array<string, mixed> $data
     *
     * @return boolean
     */
    public function update($id, $data)
    {
        /** @var \Rougin\Torin\Models\Client */
        $row = $this->findRow($id);

        /** @var string */
        $name = $data['name'];
        $row->name = $name;

        /** @var string */
        $remarks = $data['remarks'];
        $row->remarks = $remarks;

        /** @var integer */
        $type = $data['type'];
        $row->type = $type;

        return $row->save();
    }

    /**
     * @return string
     */
    protected function getCode()
    {
        $total = $this->getTotal() + 1;

        $time = date('Ymd');

        $code = sprintf('%05d', $total);

        return '01-' . $time . '-' . $code;
    }
}
