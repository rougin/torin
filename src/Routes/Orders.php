<?php

namespace Rougin\Torin\Routes;

use Psr\Http\Message\ServerRequestInterface;
use Rougin\Dexterity\Message\JsonResponse;
use Rougin\Dexterity\Route;
use Rougin\Torin\Checks\CartCheck;
use Rougin\Torin\Checks\OrderCheck;
use Rougin\Torin\Depots\ItemDepot;
use Rougin\Torin\Depots\OrderDepot;

/**
 * @package Torin
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class Orders extends Route
{
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
     * @param \Rougin\Torin\Depots\ItemDepot           $item
     * @param \Psr\Http\Message\ServerRequestInterface $request
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function check(ItemDepot $item, ServerRequestInterface $request)
    {
        $check = new CartCheck($item);

        if (! $check->isParsedValid($request))
        {
            return new JsonResponse($check->firstError(), 422);
        }

        return new JsonResponse(true);
    }

    /**
     * @param integer                                  $id
     * @param \Psr\Http\Message\ServerRequestInterface $request
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function status($id, ServerRequestInterface $request)
    {
        /** @var array<string, string> */
        $data = $request->getParsedBody();

        $status = (int) $data['status'];

        $this->order->changeStatus($id, $status);

        return new JsonResponse(true, 204);
    }

    /**
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function invalidDelete()
    {
        $errors = $this->check->errors();

        return new JsonResponse($errors, 422);
    }

    /**
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function invalidStore()
    {
        $errors = $this->check->errors();

        return new JsonResponse($errors, 422);
    }

    /**
     * @param integer $id
     *
     * @return boolean
     */
    protected function isDeleteValid($id)
    {
        return $this->order->rowExists($id);
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
     * @param integer $id
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function setDeleteData($id)
    {
        $this->order->delete($id);

        return new JsonResponse('Deleted!', 204);
    }

    /**
     * @param array<string, mixed> $params
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function setIndexData($params)
    {
        $limit = 10;

        if (array_key_exists('l', $params))
        {
            /** @var integer */
            $limit = $params['l'];
        }

        $page = 1;

        if (array_key_exists('p', $params))
        {
            /** @var integer */
            $page = $params['p'];
        }

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
