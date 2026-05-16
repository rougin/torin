<?php

namespace Rougin\Torin\Checks;

use Rougin\Dexter\Input;
use Rougin\Torin\Depots\ItemDepot;
use Rougin\Torin\Models\Order;
use Rougin\Valla\Request;

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
    protected $labels = array(

        'item_id' => 'An item',
        'quantity' => 'Quantity',
        'type' => 'Order Type',

    );

    /**
     * @var array<string, string>
     */
    protected $rules = array(

        'item_id' => 'required',
        'quantity' => 'required',
        'type' => 'required',

    );

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
    public function valid(array $data)
    {
        if (! parent::valid($data))
        {
            return count($this->errors) === 0;
        }

        $data = new Input($data);

        $item = $data->asTrueInt('item_id');

        if (! $this->item->rowExists($item))
        {
            $this->setError('item_id', 'Item not found');

            return count($this->errors) === 0;
        }

        $item = $this->item->find($item);

        // Check if order is for sale -------
        $type = $data->asTrueInt('type');

        $isSale = $type === Order::TYPE_SALE;
        // ----------------------------------

        // Check if quantity is below current stock ---
        $quantity = $data->asTrueInt('quantity');

        $lowAmount = $item->quantity < $quantity;
        // --------------------------------------------

        if ($isSale && $lowAmount)
        {
            $text = 'Not enough quantity';

            $this->setError('quantity', $text);
        }

        return count($this->errors) === 0;
    }
}
