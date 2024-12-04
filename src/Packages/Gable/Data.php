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
            $width = $cell->getWidth() ? $cell->getWidth() . '%' : null;

            $html .= '<' . $type . ' align="' . $cell->getAlign() . '" class="' . $cell->getClass() . '" colspan="' . $cell->getColspan() . '" rowspan="' . $cell->getRowspan() . '" style="' . $cell->getStyle() . '" width="' . $width . '">' . $cell->getValue() . '</' . $type . '>';
        }

        // Remove empty attributes -------------------
        $html = str_replace(' align=""', '', $html);
        $html = str_replace(' class=""', '', $html);
        $html = str_replace(' colspan=""', '', $html);
        $html = str_replace(' rowspan=""', '', $html);
        $html = str_replace(' style=""', '', $html);
        $html = str_replace(' width=""', '', $html);
        // -------------------------------------------

        return $html;
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
        $width = $this->getWidth() ? $this->getWidth() . '%' : null;

        $html = '<tr class="' . $this->getClass() . '" style="' . $this->getStyle() . '" width="' . $width . '">';

        $html .= $this->cellsToHtml($type);

        $html .= '</tr>';

        return $html;
    }
}
