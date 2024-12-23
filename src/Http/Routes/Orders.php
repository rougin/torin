<?php

namespace Rougin\Torin\Http\Routes;

use Rougin\Dexterity\Message\JsonResponse;
use Rougin\Dexterity\Route\WithIndexMethod;
use Rougin\Torin\Checks\OrderCheck;
use Rougin\Torin\Depots\OrderDepot;

/**
 * @package Torin
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class Orders
{
    use WithIndexMethod;

    /**
     * @var \Rougin\Torin\Checks\OrderCheck
     */
    protected $check;

    /**
     * @var \Rougin\Torin\Depots\OrderDepot
     */
    protected $order;

    /**
     * @param \Rougin\Torin\Checks\OrderCheck $check
     * @param \Rougin\Torin\Depots\OrderDepot $order
     */
    public function __construct(OrderCheck $check, OrderDepot $order)
    {
        $this->check = $check;

        $this->order = $order;
    }

    /**
     * @param array<string, mixed> $params
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function setIndexData($params)
    {
        /** @var integer */
        $limit = $params['l'] ?? 10;

        /** @var integer */
        $page = $params['p'] ?? 1;

        $result = $this->order->get($page, $limit);

        $items = $result->toArray();

        return new JsonResponse($items);
    }
}
