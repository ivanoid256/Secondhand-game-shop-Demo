<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Game;
use AppBundle\Form\GameType;
use AppBundle\Entity\Category;
use Doctrine\Common\Collections\Criteria;
use Symfony\Component\Form\Form;
use AppBundle\Entity\Image;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Query;
//use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Game controller.
 *
 */
class GameController extends Controller
{
	/**
	 * @Route("/category/{id}/games/{page}",name="category_games",requirements={"id":"\d+","page":"\d+"})
	 * 
	 * @param unknown $categoryId
	 */
	public function categoryGames(Category $category, Request $request, $page = 1)
	{
   		$games = $this->getDoctrine()->getRepository("AppBundle:Game")
   			->findBy(array(
   					'status' => Game::$NOT_ORDERED,
   					'category' => $category,
   			));
   		
   		$form = $this->createFilterForm($request);
   		/*if($form->isSubmitted()){
   			$games = $this->filterGames($form,$category);
   		}*/
   		
   		$paginator = $this->get('knp_paginator');
   		$games = $paginator->paginate($games,$page, 3);
   		
   		return $this->render('game/allGames.html.twig', array(
   				'games' => $games,
   				'form' => $form->createView(),
   				'categoryId' => $category->getId(),
   				'clearFilter' => false,
   		));
		
	}
    /**
     * Lists all games of current Seller.
     *
     * @Route("/seller/games", name="seller_game_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $games = $this->getUser()->getGames();

        return $this->render('game/index.html.twig', array(
            'games' => $games,
        ));
    }
	
    /**
     * Lists all games.
     * 
     * @Route("/games/{page}/{genre}", name="all_games", requirements={"page":"\d+"}) 
     */
    public function listGamesAction(Request $request, $page = 1, $genre = null)
    {
    	$clearFilterBtn = false;
   		$form = $this->createFilterForm($request);
   		
   		$qb = $this->getDoctrine()->getManager()->createQueryBuilder();
   		$qb->select('g')->from('AppBundle:Game', 'g');
   		$filterStr = $request->query->get('q');
   		   		
   		if($form->isSubmitted() || $filterStr){
	   		$clearFilterBtn = true;
   			if($filterStr){
   				$filterData = $request->query->all();
   				$games = $this->filterGames($filterData, $qb);
   				$filterStr = $filterData;
   			}else{
	   			$filterStr = $form->getData();
	   			$games = $this->filterGames($form->getData(),$qb);
	   			if($form->isEmpty()) $clearFilterBtn  = false; //!
   			}

   			//$form->setData($form->getData());
   		}else {
   			$criteria = Criteria::create()->where(Criteria::expr()->eq('status', Game::$NOT_ORDERED));
   			if($genre) $criteria->andWhere(Criteria::expr()->eq('genre', $genre));
   			$games = $qb->addCriteria($criteria)->getQuery();
   		}
   		
   		$paginator = $this->get('knp_paginator');
   		$games = $paginator->paginate($games,$page, 3);
   		if($filterStr){
   			$games->setParam('q','filter');
   			foreach ($filterStr as $key => $value){
	   			$games->setParam($key,$value);
   			}
   		}
   		
   		return $this->render('game/allGames.html.twig', array(
   				'games' => $games,
   				'form' => $form->createView(),
   				'clearFilter' =>$clearFilterBtn,
   		));
    	
    }
    /**
     * Creates a new Game entity.
     *
     * @Route("/seller/game/add", name="seller_game_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $game = new Game();
        $form = $this->createForm('AppBundle\Form\AddGameType', $game);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            
            $game->setSeller($this->getUser());
            $game->setStatus(Game::$NOT_ORDERED);
            
            $images = $game->getImages()->first();
            $game->getImages()->clear();
            
            foreach ($images as $imageFile){
            	$imageEntity = new Image();
            	//$name = $request->getBasePath().$this->getParameter('images_path').
            	$imageEntity->setName($imageFile);
            	$imageEntity->setGame($game);
            	$game->addImage($imageEntity);
            
            	$em->persist($imageEntity);
            }
            /** @var $mainImageFile \Symfony\Component\HttpFoundation\File\UploadedFile*/
            $mainImage = $game->getMainImage();
            if(!$mainImage || !$mainImage->isValid())
            	$game->setMainImage($game->getImages()->first()->getName());
            
            $em->persist($game);
            $em->flush();

            return $this->redirectToRoute('seller_game_show', array('id' => $game->getId()));
        }

        return $this->render('game/new.html.twig', array(
            'game' => $game,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Game entity.
     *
     * @Route("/seller/game/{id}", name="seller_game_show")
     * @Method("GET")
     */
    public function showToSellerAction(Game $game)
    {
        $deleteForm = $this->createDeleteForm($game);

        return $this->render('game/showToSeller.html.twig', array(
            'game' => $game,
            'delete_form' => $deleteForm->createView(),
        ));
    }
    
    /**
     * @Route("/game/{id}", name="game_show")
     * @param Game $game
     */
    public function showAction(Game $game)
    {
    	return $this->render('game/show.html.twig', array(
    			'game' => $game,
    	));
    }

    /**
     * Displays a form to edit an existing Game entity.
     *
     * @Route("/seller/game/{id}/edit", name="seller_game_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Game $game)
    {
        $deleteForm = $this->createDeleteForm($game);
        $editForm = $this->createForm('AppBundle\Form\EditGameType', $game);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($game);
            $em->flush();

            return $this->redirectToRoute('seller_game_show', array('id' => $game->getId()));
        }

        return $this->render('game/edit.html.twig', array(
            'game' => $game,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Game entity.
     *
     * @Route("/seller/game/{id}", name="seller_game_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Game $game)
    {
        $form = $this->createDeleteForm($game);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($game);
            $em->flush();
        }

        return $this->redirectToRoute('seller_game_index');
    }

    /*
     * @Route("/games/filter", name="game_filter")
     * @Method({"GET", "POST"})
     */
    private function createFilterForm(Request $request, $filterData = null)
    {
    	$form = $this->createForm('AppBundle\Form\GameFilterType'
    			,$filterData,array(
    					'action' => $this->generateUrl('all_games'), //game_filter
    			)
    	);
    	$form->handleRequest($request);
    
    	return $form;
    }
    
    /**
     * @param Form $form
     *
     * @return array(Game)
     */
    private function filterGamesUseCriteria(Form $form,Category $category = null)
    {
    	$filterData = $form->getData();
    	$criteria = Criteria::create()
    		->where(Criteria::expr()->eq("status", Game::$NOT_ORDERED));
    	if($filterData['Name']) $criteria->andWhere(Criteria::expr()->contains("name", $filterData['Name']));
   		if($filterData['Max_price']) $criteria->andWhere(Criteria::expr()->lte("price", $filterData['Max_price']));
   		if($filterData['Min_price']) $criteria->andWhere(Criteria::expr()->gte("price", $filterData['Min_price']));
   		if($filterData['Category'] && $filterData['Category']->count() > 0) 
   			$criteria->andWhere(Criteria::expr()->in("category", $filterData['Category']->toArray()));
   		if($filterData['Genre']) $criteria->andWhere(Criteria::expr()->in("genre", $filterData['Genre']));
   		if($category) $criteria->andWhere(Criteria::expr()->eq('category', $category));
    	$games = $this->getDoctrine()->getRepository("AppBundle:Game")->matching($criteria);
    		 
    	return $games;    	
    }
    
    /**
     * @param Form $form
     *
     * @return Query
     */
    private function filterGames($filterData,QueryBuilder $qb,Category $category = null)
    {    	
    	$criteria = Criteria::create()
    		->where(Criteria::expr()->eq("status", Game::$NOT_ORDERED));
    	if(isset($filterData['Max_price']) && $filterData['Max_price']) $criteria->andWhere(Criteria::expr()->lte("price", $filterData['Max_price']));
    	if(isset($filterData['Min_price']) && $filterData['Min_price']) $criteria->andWhere(Criteria::expr()->gte("price", $filterData['Min_price']));
    	if(isset($filterData['Category']) && $filterData['Category']  && $filterData['Category']->count() > 0)
    		$criteria->andWhere(Criteria::expr()->in("category", $filterData['Category']->toArray()));
    	if(isset($filterData['Genre']) && $filterData['Genre']) $criteria->andWhere(Criteria::expr()->in("genre", $filterData['Genre']));
    	if($category) $criteria->andWhere(Criteria::expr()->eq('category', $category));
    	if(isset($filterData['Name']) && $filterData['Name']){
    		$nameSearch = "%".$filterData['Name']."%";
    		$qb->andWhere($qb->expr()->like("g.name",$qb->expr()->literal($nameSearch) ));	
    	}
    	$gamesQuery = $qb->addCriteria($criteria)->getQuery();
    	//$games = $this->getDoctrine()->getRepository("AppBundle:Game")->matching($criteria);
    		 
    	return $gamesQuery;
    }
    
    /**
     * Creates a form to delete a Game entity.
     *
     * @param Game $game The Game entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Game $game)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('seller_game_delete', array('id' => $game->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
