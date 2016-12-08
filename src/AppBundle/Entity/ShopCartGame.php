<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ShopCartGame
 *
 * @ORM\Table(name="shop_cart_game")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ShopCartGameRepository")
 */
class ShopCartGame
{

    /**
     * @var int
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="ShoppingCart",inversedBy="games")
     */
    private $shoppingCart;

    /**
     * @var int
     *
     * @ORM\ManyToOne(targetEntity="ShopCartSeller",inversedBy="games")
     */ 
     /* @ORM\JoinColumns({
     * 		@ORM\JoinColumn(name="scs_sc",referencedColumnName="shopping_cart_id"),
     * 		@ORM\JoinColumn(name="scs_s",referencedColumnName="seller_id")
     * })
     */
    private $seller;

    /**
     * @var int
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Game")
     */
    private $game;


    public function __construct(ShoppingCart $shoppingCart, Game $game)
    {
    	$this->game = $game;
    	$this->shoppingCart = $shoppingCart;
    }
    
    /**
     * Set shoppingCart
     *
     * @param \AppBundle\Entity\ShoppingCart $shoppingCart
     *
     * @return ShopCartGame
     */
    public function setShoppingCart(\AppBundle\Entity\ShoppingCart $shoppingCart)
    {
        $this->shoppingCart = $shoppingCart;

        return $this;
    }

    /**
     * Get shoppingCart
     *
     * @return \AppBundle\Entity\ShoppingCart
     */
    public function getShoppingCart()
    {
        return $this->shoppingCart;
    }

    /**
     * Set seller
     *
     * @param \AppBundle\Entity\ShopCartSeller $seller
     *
     * @return ShopCartGame
     */
    public function setSeller(\AppBundle\Entity\ShopCartSeller $seller = null)
    {
        $this->seller = $seller;

        return $this;
    }

    /**
     * Get seller
     *
     * @return \AppBundle\Entity\ShopCartSeller
     */
    public function getSeller()
    {
        return $this->seller;
    }

    /**
     * Set game
     *
     * @param \AppBundle\Entity\Game $game
     *
     * @return ShopCartGame
     */
    public function setGame(\AppBundle\Entity\Game $game)
    {
        $this->game = $game;

        return $this;
    }

    /**
     * Get game
     *
     * @return \AppBundle\Entity\Game
     */
    public function getGame()
    {
        return $this->game;
    }
}
