<?php

namespace AppBundle\Form;

//use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
//use Symfony\Component\Form\Extension\Core\Type\TextareaType;
//use Symfony\Component\Form\Extension\Core\Type\TextType;
//use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
//use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class AddGameType extends GameType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
    	parent::buildForm($builder, $options);
        $builder
            ->add('mainImage',FileType::class,array(
            		'label' => 'Add Main (Title) Image',
            		'attr' => array(
            				'accept' => 'image/jpeg,image/png,image/gif,image/bmp',
            				//'class' => 'game-form-main-image',
            		),
            		'required' => false,
            ))
            ->add('images',ImageType::class,array(
            		'label' => 'Add images (.jpg|.png|.gif|.bmp)'
            ))
            ->add('Add',SubmitType::class, array(
            		'attr' => array('class' => 'game-form-add-btn'),
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
