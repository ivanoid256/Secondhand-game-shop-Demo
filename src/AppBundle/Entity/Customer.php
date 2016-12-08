<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\JoinColumn;

/**
 * Customer
 *
 * @ORM\Table(name="customer")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CustomerRepository")
 */
class Customer extends User
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
     * @ORM\OneToMany(targetEntity="Order",mappedBy="customer")
     */
    private $orders;
    
    /**
     * @ORM\OneToOne(targetEntity="ShoppingCart")
     * @JoinColumn(name="shopping_cart_id",referencedColumnName="id",nullable=true)
     * @var unknown
     */
    private $shoppingCart;
    
    public function __construct()
    {
    	$this->orders = new ArrayCollection();
    }


    /**
     * Add order
     *
     * @param \AppBundle\Entity\Commission $order
     *
     * @return Customer
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
     * Set shoppingCart
     *
     * @param \AppBundle\Entity\ShoppingCart $shoppingCart
     *
     * @return Customer
     */
    public function setShoppingCart(\AppBundle\Entity\ShoppingCart $shoppingCart = null)
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
}
