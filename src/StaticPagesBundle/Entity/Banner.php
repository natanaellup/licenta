<?php

namespace StaticPagesBundle\Entity;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class Banner
{
    const NAME_PATH_IMAGE = 'banner_image';

    const IMAGE_DIR_BOOK = 'uploads/banner';

    /**
     * @var integer
     */
    protected $id;

    /**
     * @var string
     */
    protected $link;

    /**
     * @var UploadedFile
     */
    protected $image;

    /**
     * @var string
     */
    protected $oldImageUrl;

    /**
     * @var string
     */
    protected $imageUrl;

    /**
     * @var boolean
     */
    protected $active;

    /**
     * @var integer
     */
    protected $position = 0;

    /**
     * @return UploadedFile
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param UploadedFile $image
     * @return Banner
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
     * @return Banner
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
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * @param string $link
     * @return Banner
     */
    public function setLink($link)
    {
        $this->link = $link;
        return $this;
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
     * @return Banner
     */
    public function setActive($active)
    {
        $this->active = $active;
        return $this;
    }

    /**
     * @return int
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @param $position
     * @return $this
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        if(!is_null($this->link)){
            return $this->link;
        }

        return '';
    }

}