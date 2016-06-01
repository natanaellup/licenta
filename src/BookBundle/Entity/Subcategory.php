<?php

namespace BookBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

class Subcategory
{
    /**
     * @var integer
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var Category
     */
    protected $category;

    /**
     * @var ArrayCollection
     */
    protected $books;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
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
     * @return Subcategory
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param Category $category
     * @return Subcategory
     */
    public function setCategory($category)
    {
        $this->category = $category;
        return $this;
    }
    /**
     * @param $book
     * @return $this
     */
    public function addBook($book)
    {
        $this->books->add($book);

        return $this;
    }

    /**
     * @param $book
     * @return $this
     */
    public function removeBook($book)
    {
        $this->books->removeElement($book);

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getBooks()
    {
        return $this->books;
    }

    /**
     * @param $books
     * @return $this
     */
    public function setBooks($books)
    {
        $this->books = $books;

        return $this;
    }

    /**
     * Get number of active books.
     *
     * @return int
     */
    public function getNoActiveBooks()
    {
        $count = 0;

        foreach($this->books as $book){
            if($book->isActive()){
                $count++;
            }
        }

        return $count;
    }

    /**
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