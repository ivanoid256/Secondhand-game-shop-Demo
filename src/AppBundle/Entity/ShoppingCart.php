<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * ShoppingCart
 *
 * @ORM\Table(name="shopping_cart")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ShoppingCartRepository")
 */
class ShoppingCart
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
     * @ORM\Column(name="orders", type="integer",nullable=true)
     */
    private $orders;

    /*
     * @ORM\ManyToMany(targetEntity="Game")
     * @ORM\JoinTable(name="shopping_carts_games",joinColumns=
     * {@JoinColumn(name="shopping_cart_id",referencedColumnName="id")},
     * inverseJoinColumns=
     * {@JoinColumn(name="game_id",referencedColumnName="id")}
     * )
     * @var unknown
     */
    
    /**
     * @ORM\OneToMany(targetEntity="ShopCartGame",mappedBy="shoppingCart", orphanRemoval=true)
     */
    private $games;
    
    /**
     * @ORM\OneToMany(targetEntity="ShopCartSeller",mappedBy="shoppingCart", orphanRemoval=true)
     * @var unknown
     */
    private $sellers;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->games = new \Doctrine\Common\Collections\ArrayCollection();
        $this->sellers = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set orders
     *
     * @param integer $orders
     *
     * @return ShoppingCart
     */
    public function setOrders($orders)
    {
        $this->orders = $orders;

        return $this;
    }

    /**
     * Get orders
     *
     * @return integer
     */
    public function getOrders()
    {
        return $this->orders;
    }

    /**
     * Add game
     *
     * @param \AppBundle\Entity\ShopCartGame $game
     *
     * @return ShoppingCart
     */
    public function addGame(\AppBundle\Entity\ShopCartGame $game)
    {
        $this->games[] = $game;

        return $this;
    }

    /**
     * Remove game
     *
     * @param \AppBundle\Entity\ShopCartGame $game
     */
    public function removeGame(\AppBundle\Entity\ShopCartGame $game)
    {
        $this->games->removeElement($game);
    }

    /**
     * Get games
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getGames()
    {
        return $this->games;
    }

    /**
     * Add seller
     *
     * @param \AppBundle\Entity\ShopCartSeller $seller
     *
     * @return ShoppingCart
     */
    public function addSeller(\AppBundle\Entity\ShopCartSeller $seller)
    {
        $this->sellers[] = $seller;

        return $this;
    }

    /**
     * Remove seller
     *
     * @param \AppBundle\Entity\ShopCartSeller $seller
     */
    public function removeSeller(\AppBundle\Entity\ShopCartSeller $seller)
    {
        $this->sellers->removeElement($seller);
    }

    /**
     * Get sellers
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSellers()
    {
        return $this->sellers;
    }
}
