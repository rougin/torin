<?php

namespace Rougin\Gable;

/**
 * @package Gable
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class Data extends Element
{
    /**
     * @var \Rougin\Gable\Cell[]
     */
    protected $cells = array();

    /**
     * @param \Rougin\Gable\Cell $cell
     *
     * @return self
     */
    public function addCell(Cell $cell)
    {
        $this->cells[] = $cell;

        return $this;
    }

    /**
     * @param string $type
     *
     * @return string
     */
    public function cellsToHtml($type = 'td')
    {
        $html = '';

        foreach ($this->cells as $cell)
        {
            $badges = $cell->getBadges();

            $value = $cell->getValue();

            if (count($badges) > 0)
            {
                $value = implode('', $badges);
            }

            $html .= '<' . $type . ' ' . $cell->getParsedAttrs() . '>' . $value . '</' . $type . '>';
        }

        return str_replace('<' . $type . ' >', '<' . $type . '>', $html);
    }

    /**
     * @return \Rougin\Gable\Cell[]
     */
    public function getCells()
    {
        return $this->cells;
    }

    /**
     * @return \Rougin\Gable\Cell
     */
    public function getLast()
    {
        return $this->cells[count($this->cells) - 1];
    }

    /**
     * @return integer
     */
    public function getLastIndex()
    {
        return count($this->cells) - 1;
    }

    /**
     * @param \Rougin\Gable\Cell $cell
     *
     * @return self
     */
    public function setLast(Cell $cell)
    {
        $last = count($this->cells) - 1;

        $this->cells[$last] = $cell;

        return $this;
    }

    /**
     * @param string $type
     *
     * @return string
     */
    public function toHtml($type = 'td')
    {
        $html = '<tr ' . $this->getParsedAttrs() . '>';

        $html .= $this->cellsToHtml($type);

        $html .= '</tr>';

        return str_replace('<tr >', '<tr>', $html);
    }
}
