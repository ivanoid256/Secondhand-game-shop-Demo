<?php
namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;

class TableChoiceType extends AbstractType
{
	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults(array(
            		'expanded' => true,
				'columns_count' => 0,
		));
		
		$resolver->setAllowedTypes('columns_count', array('integer', 'bool'));
	}
	
	public function buildView(FormView $view,FormInterface $form, array $options){
		if ($options['columns_count']) {
			$view->vars['columns_count'] = $options['columns_count'];
		}
	}

	public function getParent()
	{
		return ChoiceType::class;
	}

}