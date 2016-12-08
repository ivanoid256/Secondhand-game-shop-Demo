<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class ImageType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            //->add('srcRef')
            ->add('images',FileType::class,array(
            		//'label' => 'Images (.jpg|.png|.gif|.bmp)',
            		//'label_attr' => array('class' => 'image-file-label'),
            		'multiple' => true, //TRY multiple!
            		//'required' => false,
            		'label'=>false,
            		'attr' => array(
            			'accept' => 'image/jpeg,image/png,image/gif,image/bmp',
            		),
            ))
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
        ));
    }
}
