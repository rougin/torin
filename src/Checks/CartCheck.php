<?php

namespace Rougin\Torin\Checks;

use Rougin\Torin\Depots\ItemDepot;
use Rougin\Valdi\Request;

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
    ];

    /**
     * @var array<string, string>
     */
    protected $rules =
    [
        'item_id' => 'required',
        'quantity' => 'required',
    ];

    /**
     * @param \Rougin\Torin\Depots\ItemDepot $item
     */
    public function __construct(ItemDepot $item)
    {
        $this->item = $item;
    }

    /**
     * @param array<mixed, mixed>|null $data
     *
     * @return boolean
     */
    public function valid(array $data = null)
    {
        $valid = parent::valid($data);

        if (! $data || ! $valid)
        {
            return count($this->errors) === 0;
        }

        return count($this->errors) === 0;
    }
}
