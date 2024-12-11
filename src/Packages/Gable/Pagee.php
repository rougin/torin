<?php

namespace Rougin\Gable;

/**
 * @package Gable
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class Pagee
{
    const BTN_DISABLED = 0;

    const BTN_ACTIVE = 1;

    /**
     * @var integer
     */
    protected $limit = 10;

    /**
     * @var string
     */
    protected $limitKey = 'l';

    /**
     * @var string|null
     */
    protected $link = null;

    /**
     * @var integer
     */
    protected $maxTotal = 2;

    /**
     * @var integer
     */
    protected $page = 1;

    /**
     * @var string
     */
    protected $pageKey = 'p';

    /**
     * @var integer
     */
    protected $total = 0;

    /**
     * @param integer $page
     * @param integer $limit
     * @param string|null $link
     */
    public function __construct($page, $limit, $link = null)
    {
        $this->limit = (int) $limit;

        $this->link = $link;

        $this->page = (int) $page;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $html = '<div class="d-inline-block">';
        $html .= '<ul class="pagination">';

        // "First page" button ------------------------------
        $disabled = $this->page === 1;
        $link = $this->setUrl(1);
        $html .= $this->setButton('First', $link, $disabled);
        // --------------------------------------------------

        // "Previous" button -----------------------------------
        $disabled = $this->page <= 1;
        $link = $this->setUrl($this->page - 1, $disabled);
        $html .= $this->setButton('Previous', $link, $disabled);
        // -----------------------------------------------------

        foreach (range(1, $this->total) as $page)
        {
            $active = $page === $this->page;

            $link = $this->setUrl($page, $active);

            $html .= $this->setButton($page, $link, $active, self::BTN_ACTIVE);
        }

        // "Next" button -----------------------------------
        $disabled = $this->page >= $this->total;
        $link = $this->setUrl($this->page + 1, $disabled);

        $html .= $this->setButton('Next', $link, $disabled);
        // -------------------------------------------------

        // "Last page" button ------------------------------
        $disabled = $this->page === $this->total;
        $link = $this->setUrl($this->total);
        $html .= $this->setButton('Last', $link, $disabled);
        // -------------------------------------------------

        $html .= '</ul>';
        $html .= '</div>';

        return $html;
    }

    /**
     * @return integer
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * @return integer
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * @param string $link
     * @return self
     */
    public function setLink($link)
    {
        $this->link = $link;

        return $this;
    }

    /**
     * @param integer $total
     * @return self
     */
    public function setMaxPages($total)
    {
        $this->maxTotal = $total;

        return $this;
    }

    /**
     * @param integer $total
     * @return self
     */
    public function setTotal($total)
    {
        $this->total = $total;

        return $this;
    }

    /**
     * @param string $name
     * @param boolean $status
     * @param integer $type
     * @return string
     */
    protected function setButton($name, $link, $status = false, $type = self::BTN_DISABLED)
    {
        $active = $status ? ' active' : '';
        $disabled = $status ? ' disabled' : '';

        $class = $type === self::BTN_DISABLED ? $disabled : $active;

        $html = '<li class="page-item' . $class . '">';
        $html .= '<a class="page-link" href="' . $link . '">';
        $html .= '<span>' . $name . '</span>';
        $html .= '</a>';
        $html .= '</li>';

        return $html;
    }

    /**
     * @param integer $page
     * @param boolean $active
     * @return string
     */
    protected function setUrl($page, $active = false)
    {
        $link = $this->link . '?' . $this->pageKey . '=' . $page;

        $link .= '&' . $this->limitKey . '=' . $this->limit;

        return $active ? 'javascript:void(0)' : $link;
    }
}
