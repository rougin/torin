<?php

namespace Rougin\Torin\Depots;

use Rougin\Dexter\Depots\EloquentDepot;
use Rougin\Torin\Models\Item;

/**
 * @method \Rougin\Torin\Models\Item find(integer $id)
 *
 * @package Torin
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class ItemDepot extends EloquentDepot
{
    /**
     * @var \Rougin\Torin\Models\Item
     */
    protected $model;

    /**
     * @param \Rougin\Torin\Models\Item $item
     */
    public function __construct(Item $item)
    {
        $this->model = $item;
    }

    /**
     * @return \Rougin\Torin\Models\Item[]
     */
    public function all()
    {
        return $this->model->all();
    }

    /**
     * @param array<string, mixed> $data
     *
     * @return \Rougin\Torin\Models\Item
     */
    public function create($data)
    {
        $data['code'] = $this->getCode();

        /** @var \Rougin\Torin\Models\Item */
        return parent::create($data);
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
            $output[] = $item->asSelect();
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
        /** @var \Rougin\Torin\Models\Item */
        $row = $this->findRow($id);

        /** @var string */
        $name = $data['name'];
        $row->name = $name;

        /** @var string */
        $detail = $data['detail'];
        $row->detail = $detail;

        return $row->save();
    }

    /**
     * @param integer $id
     *
     * @return \Rougin\Torin\Models\Item
     */
    protected function findRow($id)
    {
        return $this->model->with('orders')->findOrFail($id);
    }

    /**
     * @return string
     */
    protected function getCode()
    {
        $total = $this->getTotal() + 1;

        $time = date('Ymd');

        $code = sprintf('%05d', $total);

        return '00-' . $time . '-' . $code;
    }
}
