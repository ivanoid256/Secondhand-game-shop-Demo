<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Image;
use AppBundle\Form\ImageType;
use AppBundle\Entity\ImageItems;
use AppBundle\Entity\Game;
use AppBundle\Entity\ImagesUploader;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

/**
 * Image controller.
 *
 * @Route("/seller/game")
 */
class ImageController extends Controller
{
    /**
     * Lists all Image entities.
     *
     * @Route("/{id}/images", name="seller_image_index",requirements={"id":"\d+"})
     * @Method("GET")
     */
    public function gameImagesAction(Game $game)
    {
        $images = $game->getImages();

        return $this->render('image/index.html.twig', array(
            'images' => $images,
        		'gameId' => $game->getId(),
        ));
    }

    /**
     * Manage Images
     *
     * @Route("/{id}/manage-images", name="manage_game_images",requirements={"id":"\d+"})
     * @Method({"GET","POST"})
     */
    public function manageGameImagesAction(Game $game, Request $request)
    {
    	/**@var $seller \AppBundle\Entity\Seller*/
    	$seller = $this->getUser();
    	$sellerId = $seller->getId();
    	$gameId = $game->getId();
    	$em = $this->getDoctrine()->getManager();
    	//$images = $game->getImages();
    	
    	$form = $this->createFormBuilder()->add('Images',ImageType::class,array(
    			'label' => 'Add images (.jpg|.png|.gif|.bmp)',
    	))->add('Send',SubmitType::class,array(
    			'label' => 'Upload Images'
    	))->getForm();

    	$form->handleRequest($request);
    	if($form->isSubmitted()){
    		$images = $form->getData()['Images']['images'];
    		foreach ($images as $image){
    			$imageEntity = new Image();
    			$imageEntity->setName($image);
    			$imageEntity->setGame($game);
	    		$game->addImage($imageEntity);
	    		$em->persist($imageEntity);
    		}
    		$em->persist($game);
    		$em->flush();
    		return $this->redirectToRoute('manage_game_images',array('id' => $game->getId()));
    	}
    	/* Delete Images Form Creation*/
    	$images = $this->getDoctrine()->getRepository('AppBundle:Image')->getGameImages($sellerId, $gameId);
    	$deleteForm = $this->createForm('AppBundle\Form\ManageImageType',null,array(
    			'images' => $images,
    	));    	
    	$deleteForm->handleRequest($request);
    	
    	if($deleteForm->isSubmitted() && $deleteForm->getData()['Images']->count() > 0){
    		$this->getDoctrine()->getRepository('AppBundle:Image')//
    			->removeImages($deleteForm->getData()['Images']);
    		return $this->redirectToRoute('manage_game_images',array('id' => $game->getId()));

    	}
    	
    	return $this->render('image/index.html.twig', array(
    			'images' => $images,
    			'game' => $game,
    			'delete_form' => $deleteForm->createView(),
    			'form' => $form->createView(),
    	));
    }

    private function reCreateDeleteImageForm($sellerId, $gameId){
    	$images = $this->getDoctrine()->getRepository('AppBundle:Image')->getGameImages($sellerId, $gameId);
    	$deleteForm = $this->createForm('AppBundle\Form\ManageImageType',null,array(
    			'images' => $images,
    	));
    	return $deleteForm;
    }
    /**
     * Creates a new Image entity.
     *
     * @Route("/{id}/images/add/old", name="seller_image_new_old",requirements={"id":"\d+"})
     * @Method({"GET", "POST"})
     */
    public function newOldAction(Request $request,Game $game)
    {
    	$count = 2;
        $images = new ImageItems();
        for ($i = 0; $i<$count; $i++){
			$images->addImage(new Image());        	
        }
        $form = $this->createForm('AppBundle\Form\ImageItemsType', $images);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
        	$em = $this->getDoctrine()->getManager();

        	foreach ($images->getImages() as $image){
	        	if(!$image->getName()) continue;
	        	// $file stores the uploaded Image file
	        	/** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
	        	$file = $image->getName();
	        	
	        	// Generate a unique name for the file before saving it
	        	$fileName = md5(uniqid()).'.'.$file->guessExtension();
	        	
	        	// Move the file to the directory where brochures are stored
	        	$file->move(
	        			$this->container->getParameter('images_directory'),
	        			$fileName
	        			);
	        	
	        	// Update the 'name' property to store the PDF file name
	        	// instead of its contents
	        	$image->setName($fileName);
	        	$image->setGame($game);
	        	
	            $em->persist($image);        		
        	}

            $em->flush();

            return $this->redirectToRoute('seller_image_index', array(
            				'id' => $game->getId(),
            		));
        }

        return $this->render('image/new.html.twig', array(
           // 'image' => $image,
            'form' => $form->createView(),
        		'gameId' => $game->getId(),
        ));
    }

    /**
     * @Route("/{id}/images/main-image/select", name="select_main_image", requirements={"id":"\d+"})
     * @Method({"GET", "POST"})
     * @param Request $request
     * @param Game $game
     */
    public function changeMainImageAction(Request $request, Game $game)
    {
    	 $form = $this->createForm('AppBundle\Form\SelectMainImageType',null,array(
    	 		'game' => $game,
    	 ));
    	 
    	 $form->handleRequest($request);
    	 
    	 if ($form->isSubmitted()){
    	 	/** @var Image $mainImage  */
    	 	$mainImage = $this->getDoctrine()->getRepository('AppBundle:Image')
    	 		->find($form->getData()['Image']);
    	 	
    	 	$game->setMainImage($mainImage->getSrcRef());
    	 	
    	 	$em = $this->getDoctrine()->getManager();
    	 	$em->persist($game);
    	 	$em->flush();
    	 	return $this->redirectToRoute('select_main_image',array('id' => $game->getId()));
    	 }
    	 
    	 return $this->render('image/selectMainImage.html.twig',array(
    	 		'form' => $form->createView(),
    	 		'mainImage' => $game->getMainImage(),
    	 		'game' => $game,
    	 ));
    }
    
    /**
     * Creates a new Image entity.
     *
     * @Route("/{id}/images/add", name="seller_image_new",requirements={"id":"\d+"})
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request,Game $game)
    {
    	$images = new ImagesUploader();
    	$form = $this->createForm('AppBundle\Form\ImageType', $images);
    	$form->handleRequest($request);
    
    	if ($form->isSubmitted() && $form->isValid()) {
    		$em = $this->getDoctrine()->getManager();
    
    		foreach ($images->getImages() as $imageFile){
    			$imageEntity = new Image();
    			$imageEntity->setName($imageFile);
    			$imageEntity->setGame($game);
    
    			$em->persist($imageEntity);
    		}
    
    		$em->flush();
    
    		return $this->redirectToRoute('seller_image_index', array(
    				'id' => $game->getId(),
    		));
    	}
    
    	return $this->render('image/new.html.twig', array(
    			// 'image' => $image,
    			'form' => $form->createView(),
    			'gameId' => $game->getId(),
    	));
    }
    
    /**
     * Finds and displays a Image entity.
     *
     * @Route("/image/{id}", name="seller_image_show",requirements={"id":"\d+"})
     * @Method("GET")
     */
    public function showAction(Image $image)
    {
        $deleteForm = $this->createDeleteForm($image);

        return $this->render('image/show.html.twig', array(
            'image' => $image,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Image entity.
     *
     * @Route("/{id}/edit", name="seller_image_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Image $image)
    {
        $deleteForm = $this->createDeleteForm($image);
        $editForm = $this->createForm('AppBundle\Form\ImageType', $image);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($image);
            $em->flush();

            return $this->redirectToRoute('seller_image_edit', array('id' => $image->getId()));
        }

        return $this->render('image/edit.html.twig', array(
            'image' => $image,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Image entity.
     *
     * @Route("/{id}", name="seller_image_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Image $image)
    {
        $form = $this->createDeleteForm($image);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($image);
            $em->flush();
        }

        return $this->redirectToRoute('seller_image_index');
    }

    /**
     * Creates a form to delete a Image entity.
     *
     * @param Image $image The Image entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Image $image)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('seller_image_delete', array('id' => $image->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
