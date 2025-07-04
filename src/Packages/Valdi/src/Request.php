<?php

namespace Rougin\Valdi;

use Psr\Http\Message\ServerRequestInterface;

/**
 * @package Valdi
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class Request extends Check
{
    /**
     * @var array<string, string>
     */
    protected $alias = array();

    /**
     * Returns the aliases defined.
     *
     * @return array<string, string>
     */
    public function alias()
    {
        return $this->alias;
    }

    /**
     * Checks if the data from getQueryParams() is valid.
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request
     *
     * @return boolean
     */
    public function isParamsValid(ServerRequestInterface $request)
    {
        /** @var array<string, string> */
        $params = $request->getQueryParams();

        return $this->valid($params);
    }

    /**
     * Checks if the data from getParsedBody() is valid.
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request
     *
     * @return boolean
     */
    public function isParsedValid(ServerRequestInterface $request)
    {
        /** @var array<string, string> */
        $parsed = $request->getParsedBody();

        return $this->valid($parsed);
    }

    /**
     * Checks if the payload is valid againsts the specified rules.
     *
     * @param array<mixed, mixed>|null $data
     *
     * @return boolean
     */
    public function valid($data = null)
    {
        return parent::valid($this->setAlias($data));
    }

    /**
     * Sets the alias for the payload.
     *
     * @param array<mixed, mixed>|null $data
     *
     * @return array<string, mixed>
     */
    protected function setAlias($data = null)
    {
        $aliases = $this->alias();

        $items = array();

        if ($data === null)
        {
            $data = $this->data;
        }

        foreach ($data as $key => $value)
        {
            if (! isset($aliases[$key]))
            {
                $items[$key] = $value;

                continue;
            }

            $items[$aliases[$key]] = $value;
        }

        return $items;
    }
}
