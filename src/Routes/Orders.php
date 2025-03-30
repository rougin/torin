<?php

namespace Rougin\Torin\Routes;

use Rougin\Dexterity\Message\HttpResponse;
use Rougin\Dexterity\Message\JsonResponse;
use Rougin\Dexterity\Route\WithIndexMethod;
use Rougin\Dexterity\Route\WithStoreMethod;
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
    use WithStoreMethod;

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
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function invalidStore()
    {
        $code = HttpResponse::UNPROCESSABLE;

        $errors = $this->check->errors();

        return new JsonResponse($errors, $code);
    }

    /**
     * @param array<string, mixed> $parsed
     *
     * @return boolean
     */
    protected function isStoreValid($parsed)
    {
        return $this->check->valid($parsed);
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

    /**
     * @param array<string, mixed> $parsed
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function setStoreData($parsed)
    {
        $this->order->create($parsed);

        return new JsonResponse('Created!', 201);
    }
}
