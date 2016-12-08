<?php
// src/AppBundle/Controller/SecurityController.php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class SecurityController extends Controller
{
	/**
	 * @Route("/seller/login", name="login")
	 */
	public function loginAction(Request $request)
	{
		$authenticationUtils = $this->get('security.authentication_utils');
		
		// get the login error if there is one
		$error = $authenticationUtils->getLastAuthenticationError();
		
		// last username entered by the user
		$lastUsername = $authenticationUtils->getLastUsername();
		
		return $this->render(
				'security/login.html.twig',
				array(
						// last username entered by the user
						'last_username' => $lastUsername,
						'error'         => $error,
				)
				);
	}
	
	/**
	 * @Route("/customer/login", name="customer_login")
	 */
	public function customerLoginAction(Request $request)
	{
		$authenticationUtils = $this->get('security.authentication_utils');
	
		// get the login error if there is one
		$error = $authenticationUtils->getLastAuthenticationError();
	
		// last username entered by the user
		$lastUsername = $authenticationUtils->getLastUsername();
	
		return $this->render(
				'security/customer_login.html.twig',
				array(
						// last username entered by the user
						'last_username' => $lastUsername,
						'error'         => $error,
				)
				);
	}
	
	/**
	 * @Route("/admin/login", name="admin_login")
	 */
	public function adminLoginAction(Request $request)
	{
		$authenticationUtils = $this->get('security.authentication_utils');
	
		// get the login error if there is one
		$error = $authenticationUtils->getLastAuthenticationError();
	
		// last username entered by the user
		$lastUsername = $authenticationUtils->getLastUsername();
	
		return $this->render(
				'security/admin_login.html.twig',
				array(
						// last username entered by the user
						'last_username' => $lastUsername,
						'error'         => $error,
				)
				);
	}
}