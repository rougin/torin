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
     * @return \Rougin\Torin\Models\Item[]
     */
    protected function getItems($page, $limit)
    {
        $model = $this->order->limit($limit);

        $offset = $this->getOffset($page, $limit);

        /** @var \Rougin\Torin\Models\Item[] */
        return $model->offset($offset)->get();
    }
}
