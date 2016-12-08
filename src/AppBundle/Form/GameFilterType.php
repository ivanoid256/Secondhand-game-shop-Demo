<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
//use AppBundle\Form\Type\TableChoiceType;

class GameFilterType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Name',TextType::class,array('required' => false))
            /*->add('category',EntityType::class,array(
            		'class' => 'AppBundle:Category',
            		'choice_label' => 'name',
            ))*/
           // ->add('genre',TextType::class)
            ->add('Max_price',MoneyType::class,array('required' => false))
            ->add('Min_price',MoneyType::class,array('required' => false))
            ->add('Genre',ChoiceType::class,array(
            		'choices' => array(
            			'Genre_6' => 'Genre_6',
            			'Genre_7' => 'Genre_7',
            			'Genre_8' => 'Genre_8',
            		),
            		'required' => false,
            		'multiple' => true,
            		//'columns_count' => 2,
            		'expanded' => true,
            ))
            ->add('Category',EntityType::class, array(
            		'class' => 'AppBundle:Category',
            		'choice_label' => 'name',
            		'required' => false,
            		'multiple' => true,
            		'expanded' => true,
            ))
            //->add('description',TextareaType::class)
            ->add('Apply_Filter',SubmitType::class)
            ->add('Apply_Filter_bottom',SubmitType::class,array('label'=>'Apply Filter'))
        ;
    }
}
