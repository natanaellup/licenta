<?php

namespace BookBundle\Entity;

class Category
{

    /**
     * Book category id.
     *
     * @var integer
     */
    private $id;

    /**
     * Category name.
     *
     * @var string
     */
    private $name;

    /**
     * Get book category id.
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get book category name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set book category name.
     *
     * @param string $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Implement to string function.
     *
     * @return string
     */
    public function __toString()
    {
        if(!is_null($this->name)){
            return $this->name;
        }

        return '';
    }
}