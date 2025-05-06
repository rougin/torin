<?php

namespace Rougin\Dexal;

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
    protected $arrays = array();

    /**
     * @var \Rougin\Dexal\Field[]
     */
    protected $fields = array();

    /**
     * @var array<string, string>
     */
    protected $modals = array();

    /**
     * @var \Rougin\Dexal\Select[]
     */
    protected $selects = array();

    /**
     * @var string
     */
    protected $link = '';

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $parent;

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
     * @param string  $field
     * @param boolean $item
     *
     * @return self
     */
    public function addField($field, $item = true)
    {
        $this->fields[] = new Field($field, $item);

        return $this;
    }

    /**
     * @param string      $name
     * @param string      $id
     * @param string|null $link
     *
     * @return self
     */
    public function addSelect($name, $id, $link = null)
    {
        $this->selects[] = new Select($name, $id, $link);

        return $this;
    }

    /**
     * @return self
     */
    public function asArray()
    {
        $index = count($this->fields) - 1;

        $this->fields[$index]->asArray();

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
     * @param string $link
     *
     * @return self
     */
    public function setLink($link)
    {
        $this->link = $link;

        return $this;
    }

    /**
     * @param string $name
     *
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;

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
