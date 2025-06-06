<?php

namespace Rougin\Dexal;

/**
 * @package Dexterity
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class Init extends Method
{
    /**
     * @var string
     */
    protected $name = 'init';

    /**
     * @var integer
     */
    protected $page = 0;

    /**
     * @param integer $page
     * @param string  $parent
     */
    public function __construct($page, $parent)
    {
        $this->page = $page;

        $this->parent = $parent;
    }

    /**
     * @return string
     */
    public function getHtml()
    {
        $fn = 'function ()';
        $fn .= '{';

        foreach ($this->selects as $select)
        {
            $name = 'this.' . $select->getName();

            $fn .= $name . ' = ' . $select;
        }

        $fn .= 'this.load(' . $this->page . ');';
        $fn .= '}';

        return $fn;
    }
}
