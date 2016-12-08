<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class GameType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',TextType::class,array(
            		'attr'=>array('placeholder' => 'Name')
            ))
            ->add('category',EntityType::class,array(
            		'class' => 'AppBundle:Category',
            		'choice_label' => 'name',
            ))
            ->add('genre',TextType::class,array(
            		'attr'=>array('placeholder' => 'Genre')
            ))
            ->add('price',MoneyType::class, array(
            		'currency' => false,
            		'attr'=>array('placeholder' => 'Price'),
            ))
            ->add('description',TextareaType::class, array(
            		'attr'=>array('placeholder' => 'Type description here...')
            ))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Game'
        ));
    }
}
