<?php
namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
//use Symfony\Bridge\Doctrine\Form\Type\DoctrineType;

class ImageEntityType extends AbstractType
{
	/*public  function buildForm(FormBuilderInterface $builder, $options){
		//$builder->add($child);
	}*/
	public function configureOptions(OptionsResolver $resolver)
	{
		//parent::configureOptions($resolver);
		$resolver->setDefaults(array(
            'expanded' => true,
			'multiple' => true,
// 			'label' => function ($image){
// 				/**@var $image \AppBundle\Entity\Image*/
// 				return $image->getSrcRef();
// 			}, //It doesn't work "Catchable Fatal Error: Object of class AppBundle\Entity\Image could not be converted to string"
			'choice_label' => 'srcRef',
			'required' => false,
			'label' => false,
		));
	}

	/*public function finishView($view, $form, $options){

	}*/
	
// 	public function finishView(FormView $view,FormInterface $form, array $options){
// 		parent::finishView($view, $form, $options);
// 		$choices = $view->vars['choices'];
// 		foreach ($view as $childView){
// 			$childView->vars['image'] = each($choices)['value']->data;
// 		}

// 	}
	
	public function getParent()
	{
		return EntityType::class;
	}
}