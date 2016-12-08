<?php

namespace AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use AppBundle\Entity\Category;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * Category controller.
 *
 */
class CategoryController extends Controller
{
    /**
     * Lists all Category entities.
     *@Route("admin/category",name="admin_category")
     *@Method({"GET"})
     */
    public function indexAction($id = -1, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $categories = $em->getRepository('AppBundle:Category')->findBy(array(),array('id' => 'ASC')) ;
        
        if( $request->get('_route') == 'admin_category'  )$template = 'admin_index';
        else $template = 'index';

        return $this->render('category/'.$template.'.html.twig', array(
            'categories' => $categories,
        	'id' => $id,
        ));
    }

    /**
     * Finds and displays a Category entity.
     *@Route("admin/category/{id}",name="category_show",requirements={"id":"\d+"})
     */
    public function showAction(Category $category)
    {

        return $this->render('category/show.html.twig', array(
            'category' => $category,
        ));
    }
    
    /**
     * @Route("admin/category/new",name="category_new")
     */
    public function newAction(Request $request){
    	$category = new Category();
    	$form = $this->createForm('AppBundle\Form\CategoryType',$category,array(
    			'action' => $this->generateUrl('category_new'),
    	));
    	
    	$form->handleRequest($request);
    	
    	if($form->isSubmitted() && $form->isValid())
    	{
    		$em = $this->getDoctrine()->getManager();
    		
    		$em->persist($category);
    		$em->flush();
    		
    		return $this->redirectToRoute('admin_category');
    	}
    	return $this->render('category/new.html.twig',array(
    			'form' => $form->createView(),
    	));
    }
}
