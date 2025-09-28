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
     * @param array<string, mixed> $data
     *
     * @return boolean
     */
    public function valid($data)
    {
        $valid = parent::valid($data);

        if (! $valid)
        {
            return count($this->errors) === 0;
        }

        /** @var integer */
        $itemId = $data['item_id'];

        if (! $this->item->rowExists($itemId))
        {
            $this->setError('item_id', 'Item not found');

            return count($this->errors) === 0;
        }

        $item = $this->item->find($itemId);

        /** @var integer */
        $type = $data['type'];

        /** @var integer */
        $quantity = $data['quantity'];

        if ($type === Order::TYPE_SALE && $item->quantity < $quantity)
        {
            $this->setError('quantity', 'Not enough quantity');
        }

        return count($this->errors) === 0;
    }
}
