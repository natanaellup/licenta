<?php

namespace ActivityBundle\Entity;

class Like
{
    private $id;

    private $book;

    private $user;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return Like
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBook()
    {
        return $this->book;
    }

    /**
     * @param mixed $book
     * @return Like
     */
    public function setBook($book)
    {
        $this->book = $book;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     * @return Like
     */
    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }


}