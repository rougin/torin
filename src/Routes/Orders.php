<?php

namespace Rougin\Torin\Routes;

use Psr\Http\Message\ServerRequestInterface;
use Rougin\Dexterity\Message\HttpResponse;
use Rougin\Dexterity\Message\JsonResponse;
use Rougin\Dexterity\Route\WithDeleteMethod;
use Rougin\Dexterity\Route\WithIndexMethod;
use Rougin\Dexterity\Route\WithStoreMethod;
use Rougin\Torin\Checks\CartCheck;
use Rougin\Torin\Checks\OrderCheck;
use Rougin\Torin\Depots\ItemDepot;
use Rougin\Torin\Depots\OrderDepot;

/**
 * @package Torin
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class Orders
{
    use WithDeleteMethod;
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
        $code = HttpResponse::UNPROCESSABLE;

        $errors = $this->check->errors();

        return new JsonResponse($errors, $code);
    }

    /**
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function invalidStore()
    {
        $code = HttpResponse::UNPROCESSABLE;

        $errors = $this->check->errors();

        return new JsonResponse($errors, $code);
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
