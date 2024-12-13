<?php

namespace Rougin\Dexter\Alpine;

use JShrink\Minifier;

/**
 * @package Dexterity
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class Method
{
    /**
     * @var string[]
     */
    protected $fields = array();

    /**
     * @var array<string, string>
     */
    protected $modals = array();

    /**
     * @var string
     */
    protected $parent;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string[]
     */
    protected $resets = array();

    /**
     * @param string $parent
     */
    public function __construct($parent)
    {
        $this->parent = $parent;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $html = Minifier::minify($this->getHtml());

        $html = $this->getName() . '=' . $html;

        return $this->parent . '.' . $html . ';';
    }

    /**
     * @param string $field
     *
     * @return self
     */
    public function addField($field)
    {
        $this->fields[] = $field;

        return $this;
    }

    /**
     * @param string $name
     *
     * @return self
     */
    public function hideModal($name)
    {
        $this->modals[$name] = 'hide';

        return $this;
    }

    /**
     * @return string
     */
    public function getHtml()
    {
        return '';
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return self
     */
    public function resetField($name)
    {
        $this->resets[] = $name;

        return $this;
    }

    /**
     * @param string $name
     *
     * @return self
     */
    public function showModal($name)
    {
        $this->modals[$name] = 'show';

        return $this;
    }
}
