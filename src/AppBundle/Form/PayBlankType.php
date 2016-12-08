<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class PayBlankType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
			->add('ownerName', TextType::class)
			->add('cardNumber', TextType::class)
			->add('sumToPay',MoneyType::class,array(
					'currency' => 'RUB',
			))
			->add('CVV',TextType::class)
			->add('send', SubmitType::class)
        ;
    }
}
