<?php

namespace AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Order;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Customer;
use AppBundle\Entity\ShopCartSeller;
use Doctrine\ORM\Id\UuidGenerator;
use AppBundle\Entity\ShoppingCart;
use AppBundle\Entity\Seller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use AppBundle\Entity\Game;
use AppBundle\Entity\OrderPackage;
use AppBundle\Entity\Admin;

/**
 * Commission controller.
 */
class OrderController extends Controller
{
    /**
     * Lists all Commission entities.
     *
     * @Route("/admin/orders", name="admin_orders")
     * @Method("GET")
     */
    public function adminOrdersAction()
    {
        $em = $this->getDoctrine()->getManager();
        
        $orders = $em->getRepository('AppBundle:Order')->findBy(array(
        		'status' => array(Order::$PAYMENT_CONFIRMED,Order::$IS_PAID,Order::$IS_CONFIRMED),
        ));

        return $this->render('commission/admin_index.html.twig', array(
            'orders' => $orders,
        ));
    }
    
    /**
     * @Route("/admin/dead-orders", name="dead_orders")
     * @Method("GET")
     */
    public function deadOrdersAction()
    {
    	$em = $this->getDoctrine()->getManager();
    
    	$orders = $em->getRepository('AppBundle:Order')->findDeadOrders();
    
    	return $this->render('commission/admin_index_dead.html.twig', array(
    			'orders' => $orders,
    	));
    }
    
    /**
     * @Route("/admin/dead-orders/remove", name="remove_dead_orders")
     * @Method("GET")
     */
    public function removeDeadOrdersAction()
    {
    	$em = $this->getDoctrine()->getManager();
    
    	$orders = $em->getRepository('AppBundle:Order')->findDeadOrders();
    	
    	foreach ($orders as $order)
    	{
    		$games = $order->getGames();
    		foreach ($games as $game){
    			$game->setCommission(null)->setStatus(Game::$NOT_ORDERED);
    			$em->persist($game);
    		}
    		$em->remove($order);
    	}
    
    	$em->flush();
    	
    	return $this->redirectToRoute('dead_orders');
    }
    
    /**
     * @Route("/customer/orders",name="customer_orders")
     */
    public function customerOrdersAction()
    {
    	$customer = $this->getUser();
    	//$customer = new Customer(); //Remove!
    	$orders = $customer->getOrders();
    	 
    	return $this->render('commission/customerIndex.html.twig', array(
    			'orders' => $orders,
    	));
    }

    /**
     * @Route("/seller/orders",name="seller_orders")
     */
    public function sellerOrdersAction()
    {
    	/**@var Seller $seller*/
    	$seller = $this->getUser();
    	$orders = $seller->getOrders();
    
    	return $this->render('commission/sellerIndex.html.twig', array(
    			'orders' => $orders,
    	));
    }
    
    /**
     * Finds and displays a Commission entity.
     * @Route("/admin/order/{id}", name="admin_order",requirements={"id":"\d+"})
     * @Method("GET")
     */
     //@Security("has_role('ROLE_ADMIN') or has_role('ROLE_SELLER') or has_role('ROLE_CUSTOMER')")
    public function showForAdminAction(Order $commission)
    {

        return $this->render('commission/show.html.twig', array(
            'commission' => $commission,
        ));
    }

    /**
     * @Route("/seller/order/{id}", name="seller_order",requirements={"id":"\d+"})
     * @Method("GET")
     */
    public function showForSellerAction(Order $order)
    {
    
    	return $this->render('commission/show.html.twig', array(
    			'commission' => $order,
    	));
    }
    
    /**
     * @Route("/customer/commission/{id}", name="customer_order",requirements={"id":"\d+"})
     * @Method("GET")
     */
    public function showForCustomerAction(Order $commission)
    {
    
    	return $this->render('commission/show.html.twig', array(
    			'commission' => $commission,
    	));
    }
    
    /**
     * @Route("admin/order/{id}/confirm", name="order_confirm",requirements={"id":"\d+"})
     */
    public function confirmAction(Order $order)
    {
    	$order->setStatus(Order::$IS_CONFIRMED);
    	
    	$sum = $order->getSum()/100 * 95;
    	
    	$em = $this->getDoctrine()->getManager();
    	$admin = $em->getRepository('AppBundle:Admin')->findAll()[0];
    	$admin->setBalance($admin->getBalance() - $sum);
    	$seller = $order->getSeller();
    	$seller->setBalance($seller->getBalance() + $sum);
    	
    	foreach ($order->getGames() as $game){
    		$game->setStatus(Game::$IS_SOLD);
    		$em->persist($game);
    	}
    	
    	$em->persist($order);
    	$em->persist($admin);
    	$em->persist($seller);
    	$em->flush();
    	return $this->redirectToRoute('admin_order',array(
    			'id' => $order->getId(),
    	));
    }
    
    /**
     * @Route("/customer/order/new",name="new_order")
     */
    public function newAction(Request $request)
    {
    	$customer = $this->getUser();
		//$customer = new Customer(); //Remove!
		$sc = $customer->getShoppingCart();
		//$sc = new ShoppingCart(); //Remove!
    	$payServiceId = $request->request->get('payServiceId');
    	
    	$orderPackage = new OrderPackage();
    	$orderPackage->setSum(0);
    	
    	foreach ($sc->getSellers() as $scs){
	    	//$scs = new ShopCartSeller($shoppingCart, $seller); //Remove!
	    	$commission = new Order($customer, $scs->getSeller(), $payServiceId, Order::$PAYMENT_NOT_CONFIRMED);
	    	$commission->setDateTime(new \DateTime());
	    	$sum = 0;
	    	foreach ($scs->getGames() as $gameRef){
	    		$game = $gameRef->getGame();
	    		$sum = $sum + $game->getPrice();
	    		$game->setStatus(Game::$IS_BEEN_ORDERING);
	    		$game->setCommission($commission);
	    	}
	    	$uuidGen = new UuidGenerator();
	    	$em = $this->getDoctrine()->getManager();
	    	$orderNumber = $uuidGen->generate($em, $scs);
	    	$commission->setSum($sum)->setOrderNumber($orderNumber);
	   		
	    	$orderPackage->setSum($sum + $orderPackage->getSum());
	    	$commission->setOrderPackage($orderPackage);
	    	
	    	$em->persist($commission);
    	}
    	
    	$orderPackage->setStatus(OrderPackage::$PAYMENT_NOT_CONFIRMED);
		$em->persist($orderPackage);
    	
    	$em->flush();
    	/*
    	return $this->redirectToRoute('pay_service',array(
    			'id' => $payServiceId,
    	));*/
    	return $this->redirectToRoute('my_payment_service',array(
    			'id' => $orderPackage->getId(),
    			'sum' => $orderPackage->getSum(),
    	));
    	
    }
    
    /**
     * @Route("/customer/order/{id}/confirmpayment",name="confirm_order_payment",requirements={"id":"\d+"})
     */
    public function confirmPaymentAction(OrderPackage $orderPackage, Request $request)
    {
    	if($orderPackage->getStatus() != OrderPackage::$IS_PAID) {
    		$orderPackage->setStatus(OrderPackage::$PAYMENT_CONFIRMED);
	    	foreach ($orderPackage->getOrders() as $order){
	    		$order->setStatus(Order::$PAYMENT_CONFIRMED);
		     	foreach ($order->getGames() as $game){
		   			$game->setStatus(Game::$IS_ORDERED);
		    	}   		
	    	}    		
    	}
    	
    	$customer = $this->getUser();
    	//$customer = new Customer(); //Remove !
    	$sc = $this->getUser()->getShoppingCart();
    	$newSc = new ShoppingCart();
    	$customer->setShoppingCart($newSc);

    	$em = $this->getDoctrine()->getManager();
    	$em->remove($sc);
    	$em->persist($newSc);
    	$em->persist($customer);
    	$em->flush();
    	
    	return $this->redirectToRoute('customer_orders');
    }
    
    /**
     * @Route("/customer/order/old",name="old")
     */
    public function newOrderAction(Request $request)
    {
    	$scid = $this->getUser()->getShoppingCart()->getId();
    	
    	$em = $this->getDoctrine()->getManager();
    	$qb = $this->getDoctrine()->getManager()->createQueryBuilder();
    	
    	$query = $qb->select('s AS seller','g AS game')
    		->from('AppBundle:ShoppingCart', 'sc')
    		->leftJoin('sc.games', 'g')
    		->from('AppBundle:Seller', 's')
    		->where('g.seller = s.id')
    		->andWhere('sc.id = :scid')
    		->setParameter('scid', $scid)
    		->orderBy('s.id')
    		->getQuery();
    	$selgams = $query->getResult();
    
    	$custPayData = $request->request->all();
    	$commission = new Order();
    	$curSel = $selgams[0]['seller'];
    	$commission->setCustomer($this->getUser())
    		->setSeller($curSel)
    		->setDateTime(new \DateTime())
    		->setIsConfirm(false);
    	$sum = 0;
    		
    	foreach ($selgams as $selgam){
  			if ($selgam == $curSel){
  				$commission->addGame($selgam['game']);
				$sum = $sum + $selgam['game']->getPrice();
  			}
  			else{
  				$commission->setSum($sum);
  				$custPayData['sumToPay']=$sum;
  				$commission->setCustomerPayData($custPayData);
  				$em->persist($commission);
  				$commission = new Order();
  				$curSel = $selgam['seller'];
  				$commission->setCustomer($this->getUser())
  					->setSeller($curSel)
  					->setDateTime(new \DateTime())
  					->setIsConfirm(false);
  				$commission->addGame($selgam['game']);
  				$sum = 0;
  				$sum = $sum + $selgam['game']->getPrice();
  			}		
    	} 
    	$custPayData['sumToPay']=$sum;
    	$commission->setCustomerPayData($custPayData);
    	$commission->setSum($sum);
    	$em->persist($commission);
    	
    	$em->flush();
    
    	return $this->redirectToRoute('commission_index');
    }
}
