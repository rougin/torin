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
     * @var boolean
     */
    protected $danger = false;

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
     * @return boolean
     */
    public function isDanger()
    {
        return $this->danger;
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
     * @param boolean $danger
     * @return self
     */
    public function setDanger($danger)
    {
        $this->danger = $danger;

        return $this;
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