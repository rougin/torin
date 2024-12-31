<?php

namespace Rougin\Torin\Http\Routes;

use Rougin\Dexterity\Message\HttpResponse;
use Rougin\Dexterity\Message\JsonResponse;
use Rougin\Dexterity\Route\WithDeleteMethod;
use Rougin\Dexterity\Route\WithIndexMethod;
use Rougin\Dexterity\Route\WithStoreMethod;
use Rougin\Dexterity\Route\WithUpdateMethod;
use Rougin\Torin\Checks\ClientCheck;
use Rougin\Torin\Depots\ClientDepot;

/**
 * @package Torin
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class Clients
{
    use WithDeleteMethod;
    use WithIndexMethod;
    use WithStoreMethod;
    use WithUpdateMethod;

    /**
     * @var \Rougin\Torin\Checks\ClientCheck
     */
    protected $check;

    /**
     * @var \Rougin\Torin\Depots\ClientDepot
     */
    protected $client;

    /**
     * @param \Rougin\Torin\Checks\ClientCheck $check
     * @param \Rougin\Torin\Depots\ClientDepot $client
     */
    public function __construct(ClientCheck $check, ClientDepot $client)
    {
        $this->check = $check;

        $this->client = $client;
    }

    /**
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function select()
    {
        $items = $this->client->getSelect();

        return new JsonResponse($items);
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
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function invalidStore()
    {
        $code = HttpResponse::UNPROCESSABLE;

        $errors = $this->check->errors();

        return new JsonResponse($errors, $code);
    }

    /**
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function invalidUpdate()
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
        return $this->client->rowExists($id);
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
     * Checks if the specified client can be updated.
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
        $this->client->delete($id);

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

        $result = $this->client->get($page, $limit);

        $clients = $result->toArray();

        return new JsonResponse($clients);
    }

    /**
     * @param array<string, mixed> $parsed
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function setStoreData($parsed)
    {
        $this->client->create($parsed);

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
        $this->client->update($id, $parsed);

        return new JsonResponse('Updated!', 204);
    }
}
