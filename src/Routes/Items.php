<?php

namespace Rougin\Torin\Routes;

use Rougin\Dexterity\Filter;
use Rougin\Dexterity\Message\JsonResponse;
use Rougin\Dexterity\Route;
use Rougin\Torin\Checks\ItemCheck;
use Rougin\Torin\Depots\ItemDepot;

/**
 * @package Torin
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class Items extends Route
{
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
    public function select()
    {
        return new JsonResponse($this->item->getSelect());
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
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function invalidStore()
    {
        $errors = $this->check->errors();

        return new JsonResponse($errors, 422);
    }

    /**
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function invalidUpdate()
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
        return $this->item->rowExists($id);
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
     * Checks if the specified item can be updated.
     *
     * @param integer              $id
     * @param array<string, mixed> $parsed
     *
     * @return boolean
     */
    protected function isUpdateValid($id, $parsed)
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
        $this->item->delete($id);

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

        $search = null;

        if (array_key_exists('k', $params))
        {
            /** @var string|null */
            $search = $params['k'];
        }

        // Add filter to search items by keyword ------
        if ($search)
        {
            $filter = new Filter;

            $filter->setStr('name', $search);
            $filter->setStr('code', $search);

            $filter->withSearch(array('name', 'code'));

            $this->item->withFilter($filter);
        }
        // --------------------------------------------

        $result = $this->item->get($page, $limit);

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

    /**
     * @param integer              $id
     * @param array<string, mixed> $parsed
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function setUpdateData($id, $parsed)
    {
        $this->item->update($id, $parsed);

        return new JsonResponse('Updated!', 204);
    }
}
