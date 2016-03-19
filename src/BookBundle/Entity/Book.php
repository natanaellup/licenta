<?php

namespace BookBundle\Entity;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use UserBundle\Entity\User;

class Book
{
    const NAME_PATH_IMAGE = 'book_image';

    const IMAGE_DIR_BOOK = 'uploads/book/image';

    const NAME_PATH_DOCUMENT = 'book_image';

    const DOCUMENT_DIR_BOOK = 'uploads/book/document';

    /**
     * Author id.
     *
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $description;

    /**
     * @var Author
     */
    private $author;

    /**
     * @var Category
     */
    private $category;

    /**
     * @var UploadedFile
     */
    private $image;

    /**
     * @var string
     */
    private $imageUrl;

    /**
     * @var string
     */
    private $oldImageUrl;

    /**
     * @var UploadedFile
     */
    private $document;

    /**
     * @var string
     */
    private $documentUrl;

    /**
     * @var string
     */
    private $oldDocumentUrl;

    /**
     * @var boolean
     */
    private $active;

    /**
     * @var User
     */
    private $user;

    /**
     * @var \DateTime
     */
    private $addDate;

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
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return Book
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return Book
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return Author
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param Author $author
     * @return Book
     */
    public function setAuthor($author)
    {
        $this->author = $author;
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
     * @return Book
     */
    public function setCategory($category)
    {
        $this->category = $category;
        return $this;
    }

    /**
     * @return UploadedFile
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param UploadedFile $image
     * @return Book
     */
    public function setImage($image)
    {
        $this->image = $image;
        return $this;
    }

    /**
     * @return string
     */
    public function getImageUrl()
    {
        return $this->imageUrl;
    }

    /**
     * @param string $imageUrl
     * @return Book
     */
    public function setImageUrl($imageUrl)
    {
        $this->oldImageUrl = $this->imageUrl;
        $this->imageUrl = $imageUrl;

        return $this;
    }

    /**
     * @return string
     */
    public function getOldImageUrl()
    {
        return $this->oldImageUrl;
    }

    /**
     * @return UploadedFile
     */
    public function getDocument()
    {
        return $this->document;
    }

    /**
     * @param UploadedFile $document
     * @return Book
     */
    public function setDocument($document)
    {
        $this->document = $document;
        return $this;
    }

    /**
     * @return string
     */
    public function getDocumentUrl()
    {
        return $this->documentUrl;
    }

    /**
     * @param string $documentUrl
     * @return Book
     */
    public function setDocumentUrl($documentUrl)
    {
        $this->oldDocumentUrl = $this->documentUrl;
        $this->documentUrl = $documentUrl;

        return $this;
    }

    /**
     * @return string
     */
    public function getOldDocumentUrl()
    {
        return $this->oldDocumentUrl;
    }

    /**
     * @return boolean
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * @param boolean $active
     * @return Book
     */
    public function setActive($active)
    {
        $this->active = $active;
        return $this;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     * @return Book
     */
    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }


    /**
     * @return \DateTime
     */
    public function getAddDate()
    {
        return $this->addDate;
    }

    /**
     * @param \DateTime $addDate
     * @return Book
     */
    public function setAddDate($addDate)
    {
        $this->addDate = $addDate;
        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        if(!is_null($this->title)){
            return $this->title;
        }

        return '';
    }
}