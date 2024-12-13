<?php

namespace Rougin\Dexter\Alpine;

/**
 * @package Dexterity
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class Edit extends Method
{
    /**
     * @var string
     */
    protected $name = 'edit';

    /**
     * @return string
     */
    public function getHtml()
    {
        $fn = 'function (item)';
        $fn .= '{';
        $fn .= 'const self = this;';

        foreach ($this->fields as $field)
        {
            $fn .= 'self.' . $field . ' = item.' . $field . ';';
        }

        foreach ($this->modals as $name => $type)
        {
            $fn .= 'Modal.' . $type . '(\'' . $name . '\');';
        }

        $fn .= '}';

        return $fn;
    }
}
