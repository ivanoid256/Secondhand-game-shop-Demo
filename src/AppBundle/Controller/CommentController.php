<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Comment;
use AppBundle\Form\CommentType;
use AppBundle\Entity\Order;
use AppBundle\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * Comment controller.
 *
 */
class CommentController extends Controller
{
    /**
     * Lists all Comment entities.
     *
     * @Route("/comment", name="comment_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $comments = $em->getRepository('AppBundle:Comment')->findAll();

        return $this->render('comment/index.html.twig', array(
            'comments' => $comments,
        ));
    }

    /**
     * @Route("/admin/order/{id}/comment/new", name="comment_new_admin", requirements={"id":"\d+"})
     * @Method({"GET", "POST"})
     * @ParamConverter("order", class="AppBundle:Order")
     */
    public function newForAdminAction(Request $request, Order $order)
    {
    	$users = new ArrayCollection();
    	$users->add($order->getCustomer());
    	$users->add($order->getSeller());
    	$userRep = $this->getDoctrine()->getRepository('AppBundle:User');
    	 
    	return $this->newComment ( $userRep,$users, $request, $order,'comment_new_admin','admin_order' );
    }
    
    /**
     * @Route("/seller/order/{id}/comment/new", name="comment_new_seller", requirements={"id":"\d+"})
     * @Method({"GET", "POST"})
     * @ParamConverter("order", class="AppBundle:Order")
     */
    public function newForSellerAction(Request $request, Order $order)
    {
    	$users = new ArrayCollection();
    	$users->add($order->getCustomer());
    	$userRep = $this->getDoctrine()->getRepository('AppBundle:User');
    	$this->addAdmints ( $users, $userRep );
    	
    	return $this->newComment ( $userRep,$users, $request, $order,'comment_new_seller','seller_order' );    	
    }
    
    /**
     * Creates a new Comment entity.
     *
     * @Route("/customer/order/{id}/comment/new", name="comment_new", requirements={"id":"\d+"})
     * @Method({"GET", "POST"})
     * @ParamConverter("order", class="AppBundle:Order")
     */
    public function newForCustomerAction(Request $request, Order $order)
    {
        $users = new ArrayCollection();
        $users->add($order->getSeller()); 
        $userRep = $this->getDoctrine()->getRepository('AppBundle:User');     
        $this->addAdmints ( $users, $userRep );        
        
        return $this->newComment ( $userRep,$users, $request, $order,'comment_new','customer_order' );

    }
	
    /**
     * @Method({"GET","POST"})
     * @Route("/admin/seller/{to}/message/new",name="message_to_seller", requirements={"to":"\d+"})
     * @param User $from
     * @param User $To
     * ParamConverter("to", class="AppBundle:User")
     */
    public function messageToSellerAction(User $to, Request $request){
    	$users = new ArrayCollection();
    	$users->add($to);
    	$userRep = $this->getDoctrine()->getRepository('AppBundle:User');
    	
    	return $this->newComment ( $userRep, $users, $request, null,'message_to_seller','seller_show' );    	
    }
    
	private function newComment($userRep, ArrayCollection $users, $request, $order, $newUrl, $redirectUrl) {
		$comment = new Comment();
        $fromUser = $this->getUser();
        $comment->setFrom($fromUser);
        
        if($order){
	        $form = $this->createForm('AppBundle\Form\CommentType', $comment, array(
	        		'users' => $users,
	        		'action' => $this->generateUrl($newUrl,array('id' => $order->getId())),
	        ));        	
        }
        else{
        	$form = $this->createForm('AppBundle\Form\CommentType', $comment, array(
        			'users' => $users,
        			'action' => $this->generateUrl($newUrl,array('to' => $users->get(0)->getId())),
        	));
        }

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
        	$comment->setOrder($order);
        	$comment->setFrom($fromUser);
        	$toUser = $userRep->find($comment->getTo());
        	$comment->setTo($toUser);
            $em = $this->getDoctrine()->getManager();
            $em->persist($comment);
            $em->flush();
			
            if($order)
            	return $this->redirectToRoute($redirectUrl, array('id' => $order->getId())); 
            else 
            	return $this->redirectToRoute($redirectUrl,array('id' => $users->get(0)->getId()));
        }
        
        return $this->render('comment/new.html.twig', array(
            'comment' => $comment,
            'form' => $form->createView(),
        ));
	}


	private function addAdmints($users, $userRep) {
		$admins = $userRep->createQueryBuilder('u')->where('u INSTANCE OF AppBundle\Entity\Admin')->getQuery()->getResult();
        foreach ($admins as $admin){
        	$users->add($admin);
        }
	}


    /**
     * Finds and displays a Comment entity.
     *
     * @Route("/comment/{id}", name="comment_show")
     * @Method("GET")
     */
    public function showAction(Comment $comment)
    {
        $deleteForm = $this->createDeleteForm($comment);

        return $this->render('comment/show.html.twig', array(
            'comment' => $comment,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Comment entity.
     *
     * @Route("/comment/{id}/edit", name="comment_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Comment $comment)
    {
        $deleteForm = $this->createDeleteForm($comment);
        $editForm = $this->createForm('AppBundle\Form\CommentType', $comment);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($comment);
            $em->flush();

            return $this->redirectToRoute('comment_edit', array('id' => $comment->getId()));
        }

        return $this->render('comment/edit.html.twig', array(
            'comment' => $comment,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Comment entity.
     *
     * @Route("/comment/{id}", name="comment_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Comment $comment)
    {
        $form = $this->createDeleteForm($comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($comment);
            $em->flush();
        }

        return $this->redirectToRoute('comment_index');
    }

    /**
     * Creates a form to delete a Comment entity.
     *
     * @param Comment $comment The Comment entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Comment $comment)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('comment_delete', array('id' => $comment->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
