<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/*
 * ImageItems
 *
 * @ORM\Table(name="image_items")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ImageItemsRepository")
 */
class ImageItems
{
    /*
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     
    private $id;*/

    /*
     * @var int
     *
     * @ORM\OneToMany(targetEntity="Image",mappedBy="items")
     */
    private $images;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->images = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /*
     * Get id
     *
     * @return integer
     
    public function getId()
    {
        return $this->id;
    }*/

    /**
     * Add image
     *
     * @param \AppBundle\Entity\Image $image
     *
     * @return ImageItems
     */
    public function addImage(\AppBundle\Entity\Image $image)
    {
        $this->images[] = $image;

        return $this;
    }

    /**
     * Remove image
     *
     * @param \AppBundle\Entity\Image $image
     */
    public function removeImage(\AppBundle\Entity\Image $image)
    {
        $this->images->removeElement($image);
    }

    /**
     * Get images
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getImages()
    {
        return $this->images;
    }
}
