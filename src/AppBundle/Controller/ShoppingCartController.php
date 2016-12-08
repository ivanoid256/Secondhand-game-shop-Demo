<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Customer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Game;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use AppBundle\Entity\ShopCartSeller;
use AppBundle\Entity\ShopCartGame;

class ShoppingCartController extends Controller
{
	/**
	 * @Route("/customer/shoppingcart/game/{id}/add",name="add_game_to_shopping_cart")
	 */
	public function addGameAction(Game $game,Request $request)
	{
		$customer = $this->getUser();
		$sc = $customer->getShoppingCart();
		
		$em = $this->getDoctrine()->getEntityManager();
		$qb = $em->createQueryBuilder();
		$scid = $sc->getId();
		$gid = $game->getId();
		$sid = $game->getSeller()->getId();
		
		$hasGame = $qb->select('g')
			->from('AppBundle:ShopCartGame', 'g')
			->where('g.shoppingCart = :scid')
			->andWhere('g.game = :gid')
			->setParameter('scid', $scid)
			->setParameter('gid', $gid)
			->getQuery()->getResult();
		
		if (empty($hasGame)){
			$scg = new ShopCartGame($sc, $game);
			$sc->addGame($scg);	
			$qb = $em->createQueryBuilder();
			$hasSeller = $qb->select('s')
				->from('AppBundle:ShopCartSeller', 's')
				->where('s.shoppingCart = :scid')
				->andWhere('s.seller = :sid')
				->setParameter('scid', $scid)
				->setParameter('sid', $sid)
				->getQuery()->getResult();
			if (empty($hasSeller)){
				$scs = new ShopCartSeller($sc, $game->getSeller());
			}else {
				$scs = $hasSeller[0];
			}
			$scs->addGame($scg);
			$scg->setSeller($scs);	
			$sc->addSeller($scs);
			$em->persist($scs);
			$em->persist($scg);
			$em->persist($sc);
			$em->flush();
		}
		
		return $this->redirectToRoute('all_games');
		/*//$baseUrl = $request->getBaseUrl();
		$baseUrl = $this->get('request_stack')->getCurrentRequest()->getSchemeAndHttpHost();
		
		return $this->redirect($baseUrl);
		
		$response = new Response();
		$response->setStatusCode(204);
		return $response;*/
	}
	
	/**
	 * @Route("/customer/shoppingcart/game/{id}/remove",name="remove_game_from_shopping_cart")
	 */
	public function removeGameAction($id,Request $request)
	{
		$customer = $this->getUser();
		$sc = $customer->getShoppingCart();
		$scid = $sc->getId();
		$em = $this->getDoctrine()->getEntityManager();
		
		$scg = $this->getDoctrine()->getRepository('AppBundle:ShopCartGame')
			->findOneBy(array('shoppingCart' => $scid, 'game' => $id ));
		$game = $scg->getGame();
		$game->setStatus(Game::$NOT_ORDERED)->setCommission(null);
		$scs = $scg->getSeller();
		$scsGames = $scs->getGames();
		$sc->removeGame($scg);
		$em->remove($scg);
		if($scsGames->count() == 1){
			$sc->removeSeller($scs);
			$em->remove($scs);
		}
		$em->persist($sc);
		$em->flush();
		
		return $this->redirectToRoute('shopping_cart');
	}
	
	/**
	 * @Route("/customer/shoppingcart/pay",name="pay")
	 */
	public function payAction()
	{
	/*
		$form = $this->createFormBuilder()
			->setAction($this->generateUrl('new_order'))
			->add('ownerName', TextType::class)
			->add('cardNumber', TextType::class)
			->add('sumToPay',MoneyType::class,array(
					'currency' => 'RUB',
					'data' => $sumToPay,
			))
			->add('CVV',TextType::class)
			->add('send', SubmitType::class)
			->getForm();*/
		
		return $this->redirectToRoute('shopping_cart');
	}
	
	/**
	 * @Route("/customer/shoppingcart",name="shopping_cart")
	 */
	public function indexAction()
	{
		$sellers = $this->getUser()->getShoppingCart()->getSellers();
		
		return $this->render('shoppingCart/index.html.twig',array(
				'sellers' => $sellers,
				//'form' => $form->createView(),
		));	
	}
	
	
	private function existInArray($items,$value)
	{
		foreach ($items as $item){
			if($item === $value) return true;
		}
		return false;
	}
}