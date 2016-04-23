<?php

namespace BookBundle\Entity;


class FreeSearch
{
    /**
     * @var string
     */
    private $freeText;

    /**
     * @var integer
     */
    private $page;

    /**
     * @return string
     */
    public function getFreeText()
    {
        return $this->freeText;
    }

    /**
     * @param string $freeText
     * @return $this
     */
    public function setFreeText($freeText)
    {
        $this->freeText = $freeText;

        return $this;
    }

    /**
     * @return int
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * @param integer $page
     * @return $this
     */
    public function setPage($page)
    {
        $this->page = $page;

        return $this;
    }
}