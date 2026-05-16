<?php

namespace Rougin\Torin\Depots;

use Rougin\Dexter\Depots\EloquentDepot;
use Rougin\Dexter\Input;
use Rougin\Torin\Models\Order;

/**
 * @method \Rougin\Torin\Models\Order find(integer $id)
 *
 * @package Torin
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class OrderDepot extends EloquentDepot
{
    /**
     * @var \Rougin\Torin\Models\Order
     */
    protected $model;

    /**
     * @param \Rougin\Torin\Models\Order $order
     */
    public function __construct(Order $order)
    {
        $this->model = $order;
    }

    /**
     * @return \Rougin\Torin\Models\Order[]
     */
    public function all()
    {
        return $this->model->all();
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
        $data = new Input($data);

        $load = array();

        $name = 'client_id';
        $value = $data->asTrueInt($name);
        $load[$name] = $value;

        $name = 'type';
        $type = $data->asTrueInt($name);
        $load[$name] = $type;

        $load['code'] = $this->getCode($type);

        $load['status'] = Order::STATUS_PENDING;

        $name = 'remarks';
        $value = $data->asStr($name);
        $load[$name] = $value;

        $name = 'created_by';
        $value = $data->asInt($name);
        $load[$name] = $value;

        $order = $this->model->create($load);

        // Add specified items per order ----------
        $data = $data->getData();

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
        // ----------------------------------------

        return $order;
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
}
