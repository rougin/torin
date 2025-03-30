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
     * @param array<string, mixed> $data
     *
     * @return \Rougin\Torin\Models\Order
     */
    public function create($data)
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

        // TODO: Create "order_item" table ---
        // -----------------------------------

        return $this->order->create($load);
    }

    /**
     * @return integer
     */
    public function getTotal()
    {
        return $this->order->count();
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
     * @return string
     */
    protected function getCode($type)
    {
        $total = $this->getTotal();

        $count = sprintf('%05d', $total);

        $code = $type . '-' . date('Ymd');

        return $code . '-' . $count;
    }
}
