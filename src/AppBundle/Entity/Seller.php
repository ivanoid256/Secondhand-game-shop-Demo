<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Seller
 *
 * @ORM\Table(name="seller")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SellerRepository")
 */

/*
 * @ORM\AttributeOverrides({
 *      @ORM\AttributeOverride(name="id",
 *          column=@ORM\Column(name="id",type="integer")
 *                    
 *      )
 * })
 */
class Seller extends User
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="bankAccount", type="string", length=12)
     */
    private $bankAccount;

    /**
     * @var int
     *
     * @ORM\OneToMany(targetEntity="Game",mappedBy="seller")
     */
    private $games;

    /**
     * @var int
     *
     * @ORM\OneToMany(targetEntity="Order",mappedBy="seller")
     */
    private $orders;
    
    /**
     * @ORM\Column(name="balance", type="integer") 
     */
    private $balance;
    
    /**
     * @ORM\Column(name="status",type="string", nullable=true) // Change nullable to false!
     * @var unknown
     */
    private $status;
    
    public static $BANNED = 'BANNED';
    public static $NORMAL = 'OK';
    /*
     * @ORM\OneToMany(targetEntity="ShopCartSeller",mappedBy="seller")
     * @var unknown
     
    private $shopCarts;*/

    public function __construct()
    {
    	$this->games = new ArrayCollection();
    	$this->orders = new ArrayCollection();
    }

    /**
     * Set bankAccount
     *
     * @param string $bankAccount
     *
     * @return Seller
     */
    public function setBankAccount($bankAccount)
    {
        $this->bankAccount = $bankAccount;

        return $this;
    }

    /**
     * Get bankAccount
     *
     * @return string
     */
    public function getBankAccount()
    {
        return $this->bankAccount;
    }

    /**
     * Add game
     *
     * @param \AppBundle\Entity\Game $game
     *
     * @return Seller
     */
    public function addGame(\AppBundle\Entity\Game $game)
    {
        $this->games[] = $game;

        return $this;
    }

    /**
     * Remove game
     *
     * @param \AppBundle\Entity\Game $game
     */
    public function removeGame(\AppBundle\Entity\Game $game)
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
     * Add order
     *
     * @param \AppBundle\Entity\Commission $order
     *
     * @return Seller
     */
    public function addOrder(\AppBundle\Entity\Order $order)
    {
        $this->orders[] = $order;

        return $this;
    }

    /**
     * Remove order
     *
     * @param \AppBundle\Entity\Commission $order
     */
    public function removeOrder(\AppBundle\Entity\Order $order)
    {
        $this->orders->removeElement($order);
    }

    /**
     * Get orders
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOrders()
    {
        return $this->orders;
    }
    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
	public function getBalance() {
		return $this->balance;
	}
	public function setBalance($balance) {
		$this->balance = $balance;
		return $this;
	}
	public function getStatus() {
		return $this->status;
	}
	public function setStatus($status) {
		$this->status = $status;
		return $this;
	}
	public static function getBANNED() {
		return self::$BANNED;
	}
	public static function setBANNED($BANNED) {
		self::$BANNED = $BANNED;
	}
	public static function getNORMAL() {
		return self::$NORMAL;
	}
	public static function setNORMAL($NORMAL) {
		self::$NORMAL = $NORMAL;
	}
	
	
	
	
}
