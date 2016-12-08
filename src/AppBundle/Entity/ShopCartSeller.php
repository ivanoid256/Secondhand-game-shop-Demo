<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ShopCartSeller
 *
 * @ORM\Table(name="shop_cart_seller",
 * 	uniqueConstraints={@ORM\UniqueConstraint(name="h_idx",columns={"shopping_cart_id","seller_id"})})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ShopCartSellerRepository")
 */
class ShopCartSeller
{
	/**
	 * @ORM\Column(name="id",type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;
    /**
     * @ORM\ManyToOne(targetEntity="ShoppingCart",inversedBy="sellers")
     */
    private $shoppingCart;

    /**
     * @ORM\ManyToOne(targetEntity="Seller")
     */
    private $seller;
    
    /**
     * @ORM\OneToMany(targetEntity="ShopCartGame",mappedBy="seller",orphanRemoval=true)
     */
    private $games;
    /**
     * Constructor
     */
    public function __construct(ShoppingCart $shoppingCart, Seller $seller)
    {
    	$this->seller = $seller;
    	$this->shoppingCart = $shoppingCart;
        $this->games = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set shoppingCart
     *
     * @param \AppBundle\Entity\ShoppingCart $shoppingCart
     *
     * @return ShopCartSeller
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
     * @param \AppBundle\Entity\Seller $seller
     *
     * @return ShopCartSeller
     */
    public function setSeller(\AppBundle\Entity\Seller $seller)
    {
        $this->seller = $seller;

        return $this;
    }

    /**
     * Get seller
     *
     * @return \AppBundle\Entity\Seller
     */
    public function getSeller()
    {
        return $this->seller;
    }

    /**
     * Add game
     *
     * @param \AppBundle\Entity\ShopCartGame $game
     *
     * @return ShopCartSeller
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
	public function getId() {
		return $this->id;
	}
	
}
