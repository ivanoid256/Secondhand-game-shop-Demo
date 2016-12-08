<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use AppBundle\Entity\Image;
use AppBundle\Form\Type\ImageEntityType;

class SelectMainImageType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Image',ImageEntityType::class,array(
            		'class' => 'AppBundle:Image',
            		'choices' => $options['game']->getImages(),
            		'multiple' => false,
            ))
           	->add('Select',SubmitType::class)
           
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            //'data_class' => 'AppBundle\Entity\ImagesUploader',
            'data_class' => null,
        		//'game' => null,
        ));
        $resolver->setRequired('game');
        $resolver->setAllowedTypes('game', 'AppBundle\Entity\Game');
    }
}
