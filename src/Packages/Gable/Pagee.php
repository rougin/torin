<?php

namespace Rougin\Gable;

/**
 * @package Gable
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class Pagee
{
    /**
     * @var integer
     */
    protected $limit = 10;

    /**
     * @var integer
     */
    protected $page = 1;

    /**
     * @param integer $page
     * @param integer $limit
     */
    public function __construct($page, $limit)
    {
        $this->limit = $limit;

        $this->page = $page;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $html = '<nav aria-label="Page navigation example">';
        $html .= '<ul class="pagination">';
        $html .= '<li class="page-item">';
        $html .= '<a class="page-link" href="#" aria-label="Previous">';
        $html .= '<span aria-hidden="true">&laquo;</span>';
        $html .= '</a>';
        $html .= '</li>';
        $html .= '<li class="page-item"><a class="page-link" href="#">1</a></li>';
        $html .= '<li class="page-item"><a class="page-link" href="#">2</a></li>';
        $html .= '<li class="page-item"><a class="page-link" href="#">3</a></li>';
        $html .= '<li class="page-item">';
        $html .= '<a class="page-link" href="#" aria-label="Next">';
        $html .= '<span aria-hidden="true">&raquo;</span>';
        $html .= '</a>';
        $html .= '</li>';
        $html .= '</ul>';
        $html .= '</nav>';

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
}
