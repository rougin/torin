<?php

namespace Rougin\Torin\Depots;

use Rougin\Dexterity\Depot;
use Rougin\Torin\Models\Order;

/**
 * @package Torin
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class OrderDepot extends Depot
{
    /**
     * @var \Rougin\Torin\Models\Order
     */
    protected $order;

    /**
     * @param \Rougin\Torin\Models\Order $order
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * @param integer $id
     * @param integer $status
     *
     * @return boolean
     */
    public function changeStatus($id, $status)
    {
        $row = $this->findRow($id);

        return $row->update(compact('status'));
    }

    /**
     * @param array<string, mixed> $data
     * @param integer|null         $actor
     *
     * @return \Rougin\Torin\Models\Order
     */
    public function create($data, $actor = null)
    {
        $load = array();

        /** @var integer */
        $clientId = $data['client_id'];
        $load['client_id'] = $clientId;

        /** @var integer */
        $type = $data['type'];
        $load['type'] = $type;

        $load['code'] = $this->getCode($type);

        $load['status'] = Order::STATUS_PENDING;

        /** @var string|null */
        $remarks = $data['remarks'];
        $load['remarks'] = $remarks;

        if (array_key_exists('created_by', $data))
        {
            /** @var integer */
            $createdBy = $data['created_by'];
            $load['created_by'] = $createdBy;
        }

        $order = $this->order->create($load);

        /** @var array<string, mixed>[] */
        $items = $data['cart'];

        foreach ($items as $item)
        {
            /** @var integer */
            $quantity = $item['quantity'];

            $row = array('quantity' => $quantity);

            if ($actor)
            {
                $row['created_by'] = $actor;
            }

            /** @var integer */
            $itemId = $item['id'];

            $order->items()->attach($itemId, $row);
        }

        return $order;
    }

    /**
     * @param integer $id
     *
     * @return boolean
     */
    public function delete($id)
    {
        return $this->findRow($id)->delete();
    }

    /**
     * @return integer
     */
    public function getTotal()
    {
        return $this->order->count();
    }

    /**
     * @param integer $id
     *
     * @return boolean
     */
    public function rowExists($id)
    {
        return $this->order->find($id) !== null;
    }

    /**
     * @param integer $page
     * @param integer $limit
     *
     * @return \Rougin\Torin\Models\Order[]
     */
    protected function getItems($page, $limit)
    {
        $model = $this->order->with(['client']);

        $model = $model->limit($limit);

        $offset = $this->getOffset($page, $limit);

        return $model->offset($offset)->get();
    }

    /**
     * @param integer $type
     *
     * @return string
     */
    protected function getCode($type)
    {
        $total = $this->getTotal() + 1;

        $count = sprintf('%05d', $total);

        $code = $type . '-' . date('Ymd');

        return $code . '-' . $count;
    }

    /**
     * @param integer $id
     *
     * @return \Rougin\Torin\Models\Order
     * @throws \UnexpectedValueException
     */
    protected function findRow($id)
    {
        return $this->order->findOrFail($id);
    }
}
