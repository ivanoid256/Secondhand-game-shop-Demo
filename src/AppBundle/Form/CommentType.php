<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class CommentType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('to',EntityType::class, array(
    			'class' => 'AppBundle:User',
            	'choice_label'=> 'username',
    			'choices' => $options['users'],
            	'attr' => array('class' => 'comment-to'),
            	'label' => 'Send comment to: ',
			))
            ->add('text',TextareaType::class, array(
            		'attr' => array('placeholder' => 'Leave comment here...'),
            		'label' => false,
            ))
            ->add('send',SubmitType::class)
            //->add('from',NumberType::class)
            //->add('order',NumberType::class)
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Comment',
        	'users' => null,
        ));
    }
}
