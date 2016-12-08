<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="order_package")
 */
class OrderPackage 
{
	/**
	 * @ORM\Column(name="id",type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;
	
	/**
	 * @ORM\OneToMany(targetEntity="Order",mappedBy="orderPackage")
	 */
	private $orders;
	
    /**
     * @ORM\Column(name="order_package_sum",type="integer")
     */
    private $sum;
    
    /**
     * @ORM\Column(name="customer_pay_data",type="json_array",nullable=true)
     */
    private $customerPayData;
    
	/**
	 * @ORM\Column(name="status",type="string")
	 */
	private $status;
	
	public  static $PAYMENT_NOT_CONFIRMED = 'PAYMENT_NOT_CONFIRMED';
	public  static $PAYMENT_CONFIRMED = 'PAYMENT_CONFIRMED';
	public  static $IS_PAID = 'IS_PAID';
	public  static $IS_CONFIRMED = 'IS_CONFIRMED';
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->orders = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set sum
     *
     * @param integer $sum
     *
     * @return OrderPackage
     */
    public function setSum($sum)
    {
        $this->sum = $sum;

        return $this;
    }

    /**
     * Get sum
     *
     * @return integer
     */
    public function getSum()
    {
        return $this->sum;
    }

    /**
     * Set customerPayData
     *
     * @param array $customerPayData
     *
     * @return OrderPackage
     */
    public function setCustomerPayData($customerPayData)
    {
        $this->customerPayData = $customerPayData;

        return $this;
    }

    /**
     * Get customerPayData
     *
     * @return array
     */
    public function getCustomerPayData()
    {
        return $this->customerPayData;
    }

    /**
     * Set status
     *
     * @param string $status
     *
     * @return OrderPackage
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Add order
     *
     * @param \AppBundle\Entity\Order $order
     *
     * @return OrderPackage
     */
    public function addOrder(\AppBundle\Entity\Order $order)
    {
        $this->orders[] = $order;

        return $this;
    }

    /**
     * Remove order
     *
     * @param \AppBundle\Entity\Order $order
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
}
