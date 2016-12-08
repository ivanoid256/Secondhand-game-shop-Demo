<?php
namespace AppBundle\EventListener;

use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use AppBundle\Entity\Image;
use Symfony\Component\HttpFoundation\RequestStack;
use AppBundle\Entity\Game;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploadImageListener {
	
	private $imagesDirectory;
	private $requestStack;
	private $imagesPath;
	
	public function __construct($imagesDirectory, RequestStack $requestStack,$imagesPath)
	{
		$this->imagesDirectory = $imagesDirectory;
		$this->requestStack = $requestStack;
		$this->imagesPath = $imagesPath;
	}
	
	public function PrePersist(LifecycleEventArgs $args )
	{
		$entity = $args->getObject();
		if ($entity instanceof Image){
			$this->saveImages($entity);
		}
		if($entity instanceof Game){
			/**@var $entity \AppBundle\Entity\Game*/
			if($entity->getMainImage() instanceof UploadedFile)
				$entity->setMainImage($this->saveMainImage($entity->getMainImage()));
			elseif( is_string($entity->getMainImage())){
				$entity->setMainImage($this->requestStack->getCurrentRequest()
					->getBasePath().$this->imagesPath.$entity->getMainImage());
			}
		}

	}
	
	private function saveMainImage(UploadedFile $mainImageFile){
		$mainImageFileName = md5(uniqid()).'.'.$mainImageFile->guessExtension();
		$directory = $this->imagesDirectory;
		$mainImageFile->move($directory,$mainImageFileName);
		$mainImage = $this->requestStack->getCurrentRequest()
			->getBasePath().$this->imagesPath.$mainImageFileName;
		return $mainImage;
	}
	
	private  function saveImages(Image $image)
	{
		$file = $image->getName();
		
		// Generate a unique name for the file before saving it
		$fileName = md5(uniqid()).'.'.$file->guessExtension();
		
		// Move the file to the directory where brochures are stored
		$file->move(
				$this->imagesDirectory,
				$fileName
				);
		
		// Update the 'name' property to store the PDF file name
		// instead of its contents
		$srcRef = $this->requestStack->getCurrentRequest()
			->getBasePath().$this->imagesPath.$fileName;
		$image->setName($fileName);
		$image->setSrcRef($srcRef);
	}
	
}