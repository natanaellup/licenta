<?php

namespace BookBundle\Entity;


class FreeSearch
{
    /**
     * @var string
     */
    private $freeText;

    /**
     * @var Author
     */
    private $author;

    /**
     * @var Subcategory
     */
    private $subcategory;

    /**
     * @return Author
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param Author $author
     * @return FreeSearch
     */
    public function setAuthor($author)
    {
        $this->author = $author;
        return $this;
    }

    /**
     * @return Subcategory
     */
    public function getSubcategory()
    {
        return $this->subcategory;
    }

    /**
     * @param Subcategory $subcategory
     * @return FreeSearch
     */
    public function setSubcategory($subcategory)
    {
        $this->subcategory = $subcategory;
        return $this;
    }

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