<?php
namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerInterface;
use AppBundle\Entity\Seller;
use Doctrine\ORM\EntityManager;
use AppBundle\Entity\Game;
use AppBundle\Entity\Category;

class LoadGameData implements FixtureInterface,ContainerAwareInterface
{
	private $container;
	private $seller;
	/**
	 * {@inheritDoc}
	 * @see \Doctrine\Common\DataFixtures\FixtureInterface::load()
	 */
	public function load(ObjectManager $manager) {
		$this->loadSeller($manager);
		$this->loadGames($manager);
	}
	
	private function loadSeller($manager)
	{
		//$manager = new EntityManager($conn, $config, $eventManager); //Remove!
		$lastSeller =$manager->getRepository('AppBundle:Seller')->findBy(array(),array('id' => 'DESC'),1)[0];
		//$lastSeller = end($lastSeller);
		if($lastSeller) $nextSellerId = $lastSeller->getId() + 1;
		else $nextSellerId = 1;
		$seller = new Seller();
		$encoder = $this->container->get('security.password_encoder');
		$password = $encoder->encodePassword($seller,'password');
		$seller->setBankAccount(rand(100000000000,999999999999))
			->setPassword($password)
			->setEmail('seller_'.$nextSellerId.'@mail.com')
			->setRoles('ROLE_SELLER')
			->setUsername('seller_'.$nextSellerId);
		$this->seller = $seller;
		$manager->persist($seller);
		$manager->flush($seller);
	}
	
	private function loadGames($manager)
	{
		$lastGame = $manager->getRepository('AppBundle:Game')->findBy(array(),array('id' => 'DESC'),1)[0];
		//$lastGame = end($lastGame);
		$categoty = $manager->getRepository('AppBundle:Category')->find(1);
		if($lastGame) $nextGameId = $lastGame->getId() + 1;
		else $nextGameId = 1;
		$gamesCount = 5;
		for ($i=$nextGameId; $i<$nextGameId+$gamesCount; $i++){
			$game = new Game();
			$game->setName('Game_'.$i)
				->setCategory($categoty)
				->setCommission(null)
				->setDescription('Description')
				->setGenre('Genre_'.rand(1,9))
				->setPrice(20+5*rand(1,2))
				->setSeller($this->seller)
				->setStatus(Game::$NOT_ORDERED);
			
			$manager->persist($game);
		}
		
		$manager->flush();
	}

	/**
	 * {@inheritDoc}
	 * @see \Symfony\Component\DependencyInjection\ContainerAwareInterface::setContainer()
	 */
	public function setContainer(ContainerInterface $container = null) {
		// TODO: Auto-generated method stub
		$this->container = $container;
	}

}