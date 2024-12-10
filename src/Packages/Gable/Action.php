<?php

namespace Rougin\Gable;

/**
 * @package Gable
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class Action
{
    /**
     * @var string|null
     */
    protected $action = null;

    /**
     * @var string|null
     */
    protected $name = null;

    /**
     * @param  string $action
     * @return self
     */
    public function ifClicked($action)
    {
        $this->action = $action;

        return $this;
    }

    /**
     * @return string|null
     */
    public function onClick()
    {
        return $this->action;
    }

    /**
     * @return string|null
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }
}
