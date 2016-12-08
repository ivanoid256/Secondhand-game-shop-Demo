<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Order;
use AppBundle\Entity\OrderPackage;
use AppBundle\Entity\Admin;
use AppBundle\Entity\Game;

class MyPaymentServiceController extends Controller
{
    /**
     * @Route("/customer/pay/{id}/{sum}",name="my_payment_service",requirements={"sum":"\d+","id":"\d+"})
     */
    public function payAction($sum, OrderPackage $orderPackage, Request $request)
    {
    	$defaultData = array('sumToPay' => $sum);
    	$form = $this->createForm('AppBundle\Form\PayBlankType',$defaultData);
    	$form->handleRequest($request);
    	
    	if($form->isSubmitted() && $form->isValid()){
    		if($form->getData()['sumToPay'] == $orderPackage->getSum()){
    			$admin = $this->getDoctrine()->getRepository('AppBundle:Admin')->findAll()[0];
    			//$admin = new Admin(); //Remove !
    			$admin->setBalance($admin->getBalance() + $orderPackage->getSum());
    			
    			$orderPackage->setStatus(OrderPackage::$IS_PAID);
    			$orderPackage->setCustomerPayData($form->getData());
    			foreach ($orderPackage->getOrders() as $order){
    				$order->setStatus(OrderPackage::$IS_PAID);
    				$order->setCustomerPayData($form->getData());
    				foreach ($order->getGames() as $game){
    					$game->setStatus(Game::$IS_ORDERED);
    				}
    			}
    			$em = $this->getDoctrine()->getManager();
    			$em->persist($orderPackage);
    			$em->flush();
    			
    			return $this->redirectToRoute('confirm_order_payment',array(
    					'id' => $orderPackage->getId(),
    			));
    		}
    		
    	}
    	
        return $this->render('AppBundle:MyPaymentService:pay.html.twig', array(
				'form' => $form->createView(),
        ));
    }

}
