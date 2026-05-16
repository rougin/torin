<?php

namespace Rougin\Torin\Depots;

use Rougin\Dexter\Depots\EloquentDepot;
use Rougin\Dexter\Input;
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
        $row = $this->findRow($id);

        $data = new Input($data);

        $name = 'name';
        $value = $data->asTrueStr($name);
        $row->name = $value;

        $name = 'detail';
        $value = $data->asTrueStr($name);
        $row->detail = $value;

        return $row->save();
    }

    /**
     * @param \Rougin\Torin\Models\Item $row
     *
     * @return array<string, mixed>
     */
    protected function asRow($row)
    {
        return $row->asRow();
    }

    /**
     * @param integer $id
     *
     * @return \Rougin\Torin\Models\Item
     */
    protected function findRow($id)
    {
        $model = $this->model->with('orders');

        return $model->findOrFail($id);
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
