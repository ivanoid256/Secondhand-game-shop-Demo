<?php
namespace AppBundle\Security;

use Symfony\Component\Security\Http\Authentication\SimplePreAuthenticatorInterface;
use Symfony\Component\Security\Core\Authentication\SimpleAuthenticatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class GuestCustomerAuthenticator implements SimplePreAuthenticatorInterface {
	/**
	 * {@inheritDoc}
	 * @see \Symfony\Component\Security\Http\Authentication\SimplePreAuthenticatorInterface::createToken()
	 */
	public function createToken(Request $request, $providerKey) {
		// TODO: Auto-generated method stub
		
	}
	
	/**
	 * {@inheritDoc}
	 * @see \Symfony\Component\Security\Core\Authentication\SimpleAuthenticatorInterface::supportsToken()
	 */
	public function supportsToken(TokenInterface $token, $providerKey) {
		// TODO: Auto-generated method stub

	}

	/**
	 * {@inheritDoc}
	 * @see \Symfony\Component\Security\Core\Authentication\SimpleAuthenticatorInterface::authenticateToken()
	 */
	public function authenticateToken(TokenInterface $token, UserProviderInterface $userProvider, $providerKey) {
		// TODO: Auto-generated method stub

	}


}