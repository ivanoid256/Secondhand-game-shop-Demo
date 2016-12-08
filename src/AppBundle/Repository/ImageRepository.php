<?php

namespace AppBundle\Repository;

/**
 * ImageRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ImageRepository extends \Doctrine\ORM\EntityRepository
{
	public function getGameImages($sellerId,$gameId){
		$qb = $this->createQueryBuilder('im');
		$qb->select('im')->from('AppBundle:Seller', 's')->from('AppBundle:Game', 'g')
			->where('s.id = :sellerId')->andWhere('g.id = :gameId')->andWhere('im.game = g.id')
			->andWhere('g.seller = s.id')
			->setParameter('sellerId', $sellerId)->setParameter('gameId', $gameId);
		$images = $qb->getQuery()->getResult();
		return $images;
		
	}
	public function removeImages($images){
 		//$em = $this->_em;
		/**@var \Doctrine\Common\Collections\ArrayCollection $images*/
		$imagesIds = array();
		foreach ($images as $image){
			$imagesIds[] = $image->getId();
		}
		$qb = $this->createQueryBuilder('im'); 
		return $qb->delete()->where($qb->expr()->in("im.id", $imagesIds))->getQuery()->getArrayResult();
// 		foreach ($images as $image){
// 			$em->remove($image);
// 		}
// 		$em->flush();
	}
}
