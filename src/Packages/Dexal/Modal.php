<?php

namespace Rougin\Dexal;

/**
 * @package Dexterity
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class Modal extends Method
{
    /**
     * @return string
     */
    public function getHtml()
    {
        $params = array();

        foreach ($this->fields as $field)
        {
            if (! $field->isItem())
            {
                $params[] = $field;
            }
        }

        $fn = 'function (item)';

        // If there are fields not counted from item, use it as params instead ---
        if (count($params) > 0)
        {
            $fn = 'function (item, ' . implode(', ', $params) . ')';
        }
        // -----------------------------------------------------------------------

        $fn .= '{';
        $fn .= 'const self = this;';

        foreach ($this->fields as $field)
        {
            $fn .= $field->getSelf() . ' = ' . $field->getItem() . ';';
        }

        foreach ($this->modals as $name => $type)
        {
            $fn .= 'Modal.' . $type . '(\'' . $name . '\');';
        }

        $fn .= '}';

        return $fn;
    }
}
