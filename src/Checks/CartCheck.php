<?php

namespace Rougin\Torin\Checks;

use Rougin\Torin\Depots\ItemDepot;
use Rougin\Torin\Models\Order;
use Rougin\Validia\Request;

/**
 * @package Torin
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class CartCheck extends Request
{
    /**
     * @var \Rougin\Torin\Depots\ItemDepot
     */
    protected $item;

    /**
     * @var array<string, string>
     */
    protected $labels =
    [
        'item_id' => 'An item',
        'quantity' => 'Quantity',
        'type' => 'Order Type',
    ];

    /**
     * @var array<string, string>
     */
    protected $rules =
    [
        'item_id' => 'required',
        'quantity' => 'required',
        'type' => 'required',
    ];

    /**
     * @param \Rougin\Torin\Depots\ItemDepot $item
     */
    public function __construct(ItemDepot $item)
    {
        $this->item = $item;
    }

    /**
     * @param array<string, string>|null $data
     *
     * @return boolean
     */
    public function valid($data = null)
    {
        $valid = parent::valid($data);

        if (! $data || ! $valid)
        {
            return false;
        }

        $itemId = (int) $data['item_id'];

        $item = $this->item->find($itemId);

        if (! $item)
        {
            $this->setError('item_id', 'Item not found');

            return count($this->errors) === 0;
        }

        $quantity = (int) $data['quantity'];

        $type = (int) $data['type'];

        if ($type === Order::TYPE_SALE && $item->quantity < $quantity)
        {
            $this->setError('quantity', 'Not enough quantity');
        }

        return count($this->errors) === 0;
    }
}
