<?php

namespace BookBundle\Entity;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class Author
{
    const NAME_PATH = 'author_image';

    const IMAGE_DIR = 'uploads/author_image';

    /**
     * Author id.
     *
     * @var integer
     */
    private $id;

    /**
     * Author first name.
     *
     * @var string
     */
    private $firstName;

    /**
     * Author last name.
     *
     * @var string
     */
    private $lastName;

    /**
     * Author description.
     *
     * @var string
     */
    private $description;

    /**
     * Image url.
     *
     * @var string
     */
    private $imageUrl;

    /**
     * Image file.
     *
     * @var UploadedFile
     */
    private $image;

    /**
     * Old image url.
     *
     * @var string
     */
    private $oldImageUrl;

    /**
     * Active author?
     *
     * @var boolean
     */
    private $active;

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
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     * @return Author
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
        return $this;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     * @return Author
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
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
     * @return Author
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @param UploadedFile|null $image
     * @return $this
     */
    public function setImage(UploadedFile $image = null)
    {
        $this->image = $image;

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
     * @return string
     */
    public function getOldImageUrl()
    {
        return $this->oldImageUrl;
    }

    /**
     * @param string $imageUrl
     * @return $this
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
    public function getImageUrl()
    {
        return $this->imageUrl;
    }

    /**
     * @return bool
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * @param bool $active
     * @return $this
     */
    public function setActive($active)
    {
        $this->active = $active;
        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        if(!is_null($this->firstName) && !is_null($this->lastName)){
            return $this->firstName.' '.$this->lastName;
        }

        return '';
    }
}