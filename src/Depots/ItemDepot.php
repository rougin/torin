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
        return $this->item->create($data);
    }
}
