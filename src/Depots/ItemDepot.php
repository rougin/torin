<?php

namespace Rougin\Torin\Depots;

use Rougin\Dexterity\Depot;
use Rougin\Torin\Models\Item;

/**
 * @package Torin
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class ItemDepot extends Depot
{
    /**
     * @var \Rougin\Torin\Models\Item
     */
    protected $item;

    /**
     * @param \Rougin\Torin\Models\Item $item
     */
    public function __construct(Item $item)
    {
        $this->item = $item;
    }

    /**
     * @param array<string, mixed> $data
     *
     * @return \Rougin\Torin\Models\Item
     */
    public function create($data)
    {
        $data['code'] = $this->getCode();

        return $this->item->create($data);
    }

    /**
     * @return integer
     */
    public function getTotal()
    {
        return $this->item->count();
    }

    /**
     * @param integer $id
     *
     * @return boolean
     */
    public function rowExists($id)
    {
        return $this->item->find($id) !== null;
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
     * @return boolean
     */
    protected function deleteRow($id)
    {
        return $this->findRow($id)->delete();
    }

    /**
     * @param integer $id
     *
     * @return \Rougin\Torin\Models\Item
     * @throws \UnexpectedValueException
     */
    protected function findRow($id)
    {
        return $this->item->findOrFail($id);
    }

    /**
     * @return string
     */
    protected function getCode()
    {
        $total = $this->getTotal() + 1;

        $time = date('Ymd');

        $code = str_pad($total, 5, '0', STR_PAD_LEFT);

        return '00-' . $time . '-' . $code;
    }

    /**
     * @param integer $page
     * @param integer $limit
     *
     * @return \Rougin\Torin\Models\Item[]
     */
    protected function getItems($page, $limit)
    {
        $model = $this->item->limit($limit);

        $offset = $this->getOffset($page, $limit);

        /** @var \Rougin\Torin\Models\Item[] */
        return $model->offset($offset)->get();
    }
}
