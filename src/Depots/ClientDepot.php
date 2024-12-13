<?php

namespace Rougin\Torin\Depots;

use Rougin\Dexterity\Depot;
use Rougin\Torin\Models\Client;

/**
 * @package Torin
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class ClientDepot extends Depot
{
    /**
     * @var \Rougin\Torin\Models\Client
     */
    protected $client;

    /**
     * @param \Rougin\Torin\Models\Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param array<string, mixed> $data
     *
     * @return \Rougin\Torin\Models\Client
     */
    public function create($data)
    {
        $data['code'] = $this->getCode();

        return $this->client->create($data);
    }

    /**
     * @return integer
     */
    public function getTotal()
    {
        return $this->client->count();
    }

    /**
     * @param integer $id
     *
     * @return boolean
     */
    public function rowExists($id)
    {
        return $this->client->find($id) !== null;
    }

    /**
     * @param integer              $id
     * @param array<string, mixed> $data
     *
     * @return boolean
     */
    public function update($id, $data)
    {
        $row = $this->findRow($id);

        /** @var string */
        $name = $data['name'];
        $row->name = $name;

        /** @var string */
        $remarks = $data['remarks'];
        $row->remarks = $remarks;

        /** @var integer */
        $type = $data['type'];
        $row->type = $type;

        return $row->save();
    }

    /**
     * @param integer $id
     *
     * @return boolean
     */
    protected function deleteRow($id)
    {
        return $this->findRow($id)->delete();
    }

    /**
     * @param integer $id
     *
     * @return \Rougin\Torin\Models\Client
     * @throws \UnexpectedValueException
     */
    protected function findRow($id)
    {
        return $this->client->findOrFail($id);
    }

    /**
     * @return string
     */
    protected function getCode()
    {
        $total = $this->getTotal() + 1;

        $time = date('Ymd');

        $code = sprintf('%05d', $total);

        return '01-' . $time . '-' . $code;
    }

    /**
     * @param integer $page
     * @param integer $limit
     *
     * @return \Rougin\Torin\Models\Client[]
     */
    protected function getItems($page, $limit)
    {
        $model = $this->client->limit($limit);

        $offset = $this->getOffset($page, $limit);

        /** @var \Rougin\Torin\Models\Client[] */
        return $model->offset($offset)->get();
    }
}
