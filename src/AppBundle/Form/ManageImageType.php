<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\Form\Type\ImageEntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ManageImageType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
    	$opts = array(
//         			'expanded' => true,
//         			'multiple' => true,
//         			'choice_label' => 'srcRef',
//         			'required' => false,
//         			'label' => false,
        			'class' => 'AppBundle:Image',
        	);
		$opts['choices'] = $options['images'];
		$attr = count($options['images']) ? array('class' => 'delete-selected-images') : array('class' => 'delete-selected-images','disabled' => 'disabled');
        $builder
        	->add('Images',ImageEntityType::class,$opts)
        	->add('Delete Selected Images',SubmitType::class, array(
        			'attr' => $attr,
        	))
        ;
        //if(count($options['images'])){}
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => null,
        	'images' => null,
        ));
        $resolver->setRequired('images');
       	$resolver->setAllowedTypes('images', array('AppBundle\Entity\Image','array','AppBundle\Entity\Game','null'));
    }
}
