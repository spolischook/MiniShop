<?php

namespace Spolischook\MiniShopBundle\Form\Type;

use Spolischook\MiniShopBundle\Entity\Countries;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class OrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('country', 'choice', [
                'choices' => Countries::$countries,
                'preferred_choices' => ['UA', 'US', 'CA', 'DE', 'AU'],
                'data' => 'UA',
            ])
            ->add('address')
            ->add('phone')
            ->add('comment')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Spolischook\MiniShopBundle\Entity\Order',
        ));
    }

    public function getName()
    {
        return 'task';
    }
}
