<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Image
 *
 * @ORM\Table(name="image")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ImageRepository")
 */
class Image
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\ManyToOne(targetEntity="Game",inversedBy="images")
     * @ORM\JoinColumn(name="game_id",referencedColumnName="id",nullable=true)
     */
    private $game;

    /**
     * @var string
     *
     * @ORM\Column(name="srcRef", type="string", length=255,nullable=true)
     */
    private $srcRef;

    
    /** 
     * @Assert\File(mimeTypes={"image/jpeg","image/gif","image/png","image/bmp"})
     * 
     * @ORM\Column(name="name",type="string", length=128,nullable=true)
     */
    private $name;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set game
     *
     * @param integer $game
     *
     * @return Image
     */
    public function setGame($game)
    {
        $this->game = $game;

        return $this;
    }

    /**
     * Get game
     *
     * @return int
     */
    public function getGame()
    {
        return $this->game;
    }

    /**
     * Set srcRef
     *
     * @param string $srcRef
     *
     * @return Image
     */
    public function setSrcRef($srcRef)
    {
        $this->srcRef = $srcRef;

        return $this;
    }

    /**
     * Get srcRef
     *
     * @return string
     */
    public function getSrcRef()
    {
        return $this->srcRef;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Image
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}
