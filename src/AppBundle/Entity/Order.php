<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Order
 *
 * @ORM\Table(name="commission")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CommissionRepository")
 */
class Order
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
     * @ORM\ManyToOne(targetEntity="Customer",inversedBy="orders")
     */
    private $customer;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateTime", type="datetime")
     */
    private $dateTime;

    /**
     * @var int
     *
     * @ORM\OneToMany(targetEntity="Game",mappedBy="commission")
     */
    private $games;

    /**
     * @var bool
     *
     * @ORM\Column(name="status",type="string")
     */
    private $status;

    /**
     * @var guid
     *
     * @ORM\Column(name="orderNumber", type="guid", unique=true)
     */
    private $orderNumber;

    /**
     * @var int
     *
     * @ORM\ManyToOne(targetEntity="Seller",inversedBy="orders")
     * @ORM\JoinColumn(name="seller_id",referencedColumnName="id")
     */
    private $seller;

    /**
     * @ORM\Column(name="order_sum",type="integer")
     * @var unknown
     */
    private $sum;
    
    /**
     * @ORM\Column(name="customer_pay_data",type="json_array",nullable=true)
     * @var unknown
     */
    private $customerPayData;
    
    /**
     * @ORM\Column(name="pay_service",type="integer")
     */
    private $payService;
    
    /**
     * @ORM\OneToMany(targetEntity="Comment",mappedBy="order")
     */
    private $comments;
    
    /**
     * @ORM\ManyToOne(targetEntity="OrderPackage", inversedBy="orders")
     */
    private $orderPackage;

    public  static $PAYMENT_NOT_CONFIRMED = 'PAYMENT_NOT_CONFIRMED';
    public  static $PAYMENT_CONFIRMED = 'PAYMENT_CONFIRMED';
    public  static $IS_PAID = 'IS_PAID';
    public  static $IS_CONFIRMED = 'IS_CONFIRMED';
    /**
     * Constructor
     */
    public function __construct(Customer $customer, Seller $seller,$payService,$status)
    {
    	$this->customer = $customer;
    	$this->seller = $seller;
    	$this->payService = $payService;
    	$this->status = $status;
        $this->games = new \Doctrine\Common\Collections\ArrayCollection();
        $this->comments = new ArrayCollection();
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
     * Set dateTime
     *
     * @param \DateTime $dateTime
     *
     * @return Order
     */
    public function setDateTime($dateTime)
    {
        $this->dateTime = $dateTime;

        return $this;
    }

    /**
     * Get dateTime
     *
     * @return \DateTime
     */
    public function getDateTime()
    {
        return $this->dateTime;
    }

    /**
     * Get orderNumber
     *
     * @return guid
     */
    public function getOrderNumber()
    {
        return $this->orderNumber;
    }

    /**
     * Set customer
     *
     * @param \AppBundle\Entity\Customer $customer
     *
     * @return Order
     */
    public function setCustomer(\AppBundle\Entity\Customer $customer = null)
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * Get customer
     *
     * @return \AppBundle\Entity\Customer
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * Add game
     *
     * @param \AppBundle\Entity\Game $game
     *
     * @return Order
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
     * Set seller
     *
     * @param \AppBundle\Entity\Seller $seller
     *
     * @return Order
     */
    public function setSeller(\AppBundle\Entity\Seller $seller = null)
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
	public function getSum() {
		return $this->sum;
	}
	public function setSum($sum) {
		$this->sum = $sum;
		return $this;
	}
	public function getCustomerPayData() {
		return $this->customerPayData;
	}
	public function setCustomerPayData($customerPayData) {
		$this->customerPayData = $customerPayData;
		return $this;
	}
	public function getStatus() {
		return $this->status;
	}
	public function setStatus($status) {
		$this->status = $status;
		return $this;
	}
	public function getPayService() {
		return $this->payService;
	}
	public function setPayService($payService) {
		$this->payService = $payService;
		return $this;
	}
	public function setOrderNumber($orderNumber) {
		$this->orderNumber = $orderNumber;
		return $this;
	}
	
	/**
	 * Add comment
	 *
	 * @param \AppBundle\Entity\Comment $comment
	 *
	 * @return Order
	 */
	public function addComment(\AppBundle\Entity\Comment $comment)
	{
		$this->comments[] = $comment;
	
		return $this;
	}
	
	/**
	 * Remove comment
	 *
	 * @param \AppBundle\Entity\Comment $comment
	 */
	public function removeComment(\AppBundle\Entity\Comment $comment)
	{
		$this->comments->removeElement($comment);
	}
	
	/**
	 * Get comments
	 *
	 * @return \Doctrine\Common\Collections\Collection
	 */
	public function getComments()
	{
		return $this->comments;
	}
	public function getOrderPackage() {
		return $this->orderPackage;
	}
	public function setOrderPackage($orderPackage) {
		$this->orderPackage = $orderPackage;
		return $this;
	}
		
	
}
