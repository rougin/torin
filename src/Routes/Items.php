<?php

namespace Rougin\Torin\Routes;

use Rougin\Dexterity\Message\HttpResponse;
use Rougin\Dexterity\Message\JsonResponse;
use Rougin\Dexterity\Route\WithIndexMethod;
use Rougin\Dexterity\Route\WithStoreMethod;
use Rougin\Gable\Table;
use Rougin\Temply\Plate;
use Rougin\Torin\Checks\ItemCheck;
use Rougin\Torin\Depots\ItemDepot;

/**
 * @package Torin
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class Items
{
    use WithIndexMethod;
    use WithStoreMethod;

    /**
     * @var \Rougin\Torin\Checks\ItemCheck
     */
    protected $check;

    /**
     * @var \Rougin\Torin\Depots\ItemDepot
     */
    protected $item;

    /**
     * @param \Rougin\Torin\Checks\ItemCheck $check
     * @param \Rougin\Torin\Depots\ItemDepot $item
     */
    public function __construct(ItemCheck $check, ItemDepot $item)
    {
        $this->check = $check;

        $this->item = $item;
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
     * Executes the logic for returning an array of items.
     *
     * @param array<string, mixed> $params
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function setIndexData($params)
    {
        $page = $params['p'] ?? 1;

        $result = $this->item->get($page, $params['l'] ?? 10);

        return new JsonResponse($result->toArray());
    }

    /**
     * @param array<string, mixed> $parsed
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function setStoreData($parsed)
    {
        $this->item->create($parsed);

        return new JsonResponse('Created!', 201);
    }
}
