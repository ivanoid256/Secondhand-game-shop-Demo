<?php

namespace AppBundle\Security\User;

use Symfony\Bridge\Doctrine\Security\User\EntityUserProvider;
use Doctrine\Common\Persistence\ManagerRegistry;
use AppBundle\Entity\Customer;
use AppBundle\Entity\ShoppingCart;

class EntityGuestUserProvider extends EntityUserProvider
{
	protected $gregistry;
	protected $gmanagerName;
	protected $gclassOrAlias;
	protected $gproperty;
	
    public function __construct(ManagerRegistry $registry, $classOrAlias, $property = null, $managerName = null)
    {
    	$this->gregistry = $registry;
    	$this->gmanagerName = $managerName;
    	$this->gclassOrAlias = $classOrAlias;
    	$this->gproperty = $property;
        parent::__construct($registry, $classOrAlias,$property, $managerName);
    }
    
    public function createGuestUser(){
    	/**@var \Doctrine\ORM\EntityManager $em */
    	$em = $this->getGObjectManager();
    	/**@var \AppBundle\Entity\Customer $customer */
    	$customer = new $this->gclassOrAlias;
    	$sc = new ShoppingCart();
    	$customer->setShoppingCart($sc)
    		->setUsername('guest_customer'.uniqid())
    		->setEmail('guest@customer.com')
    		->setPassword('guest_password')
    		->setRoles(array('ROLE_GUEST_CUSTOMER'));
    	$em->persist($customer);
    	$em->persist($sc);
    	$em->flush();
    	
    	return $customer;	
    }
    
    protected function getGObjectManager()
    {
    	return $this->gregistry->getManager($this->gmanagerName);
    }
}