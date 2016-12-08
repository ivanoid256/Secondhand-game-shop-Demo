<?php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\ShoppingCart;
use Doctrine\ORM\Query;
use Doctrine\ORM\Query\AST\Join;

/**
 * @Route("/experiment") 
 * @author Ivan
 *
 */
class ExperimentController extends Controller
{
	/**
	 * @Route("/shopping-cart/{id}",name="experiment_shopping_cart",requirements={"id":"\d+"})
	 */
	public function shoppingCartAction(ShoppingCart $sc){
		$em = $this->getDoctrine()->getManager();
		$qb = $em->createQueryBuilder();
// 		$query = $qb->select('s','g')->from('AppBundle:Seller', 's')->from('AppBundle:ShopCartGame', 'scg')->from('AppBundle:ShoppingCart', 'sc')
// 			->from('AppBundle:Game', 'g')->where('sc.id = :scId')->andWhere('scg.game = g.id')->andWhere('sc.id = scg.shoppingCart')
// 			->andWhere('s.id = g.seller')->setParameter('scId', $sc->getId())
// 			->getQuery();
		
// 		$query = $qb->select('sc','scg','g','s','game')->from('AppBundle:Game','game')
// 			->from('AppBundle:ShoppingCart', 'sc')->join('sc.games', 'scg')
// 			->join('scg.game', 'g')->join('g.seller', 's')->where('sc.id = :scId')->setParameter('scId', $sc->getId())
// 			->getQuery();
		
		$query = $qb->select('s','g')->from('AppBundle:Seller', 's')->join('s.games', 'g')
			->leftJoin('AppBundle:ShopCartGame', 'scg',\Doctrine\ORM\Query\Expr\Join::WITH,'scg.game = g.id')
			->leftJoin('scg.shoppingCart', 'sc')->where('sc.id = :scId')->setParameter('scId', $sc->getId())
			->getQuery();
		
		$qr = $query->getResult(Query::HYDRATE_ARRAY); //
		$sellers = $qr;
// 		$games = $qr['g'];
			
		return $this->render('experiment/shopping_cart.html.twig',array(
				'sellers' => $sellers,
// 				'games' => $games,
		));
	}
}