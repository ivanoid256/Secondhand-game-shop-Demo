<?php
namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerInterface;
use AppBundle\Entity\Category;

class LoadCategoryData implements FixtureInterface,ContainerAwareInterface
{
	private $container;

	/**
	 * {@inheritDoc}
	 * @see \Doctrine\Common\DataFixtures\FixtureInterface::load()
	 */
	public function load(ObjectManager $manager) {
		$this->loadCategory($manager);
	}
	
	private function loadCategory($manager)
	{
		$lastCategory = $manager->getRepository('AppBundle:Category')->findBy(array(),array('id' => 'DESC'),1)[0];
		if($lastCategory) $nextCategoryId = $lastCategory->getId() + 1;
		else $nextCategoryId = 1;
		$categoryCount = 7;
		for ($i=$nextCategoryId; $i<$nextCategoryId+$categoryCount; $i++){
			$category = new Category();
			$category->setName('Category_'.$i);
			
			$manager->persist($category);
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