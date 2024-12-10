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
        $item = $this->findRow($id);

        /** @var string */
        $name = $data['name'];
        $item->name = $name;

        /** @var string */
        $detail = $data['detail'];
        $item->detail = $detail;

        return $item->save();
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
     * @return mixed
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
        /** @var string */
        $data = PHP_MAJOR_VERSION < 7 ? openssl_random_pseudo_bytes(16) : random_bytes(16);

        $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // Set version to 0100
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // Set bits 6-7 to 10

        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
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

    /**
     * @return integer
     */
    protected function getTotal()
    {
        return $this->item->count();
    }
}
