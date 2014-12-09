<?php

namespace Spolischook\MiniShopBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MoneyTransferType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fromAccount', 'choice', [
                'choices' => ['card' => 'З карти', 'cash' => 'From cash'],
            ])
            ->add('toAccount', 'choice', [
                'choices' => ['card' => 'На карту', 'cash' => 'To cash'],
            ])
            ->add('comment')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Spolischook\MiniShopBundle\Entity\MoneyTransfer',
        ));
    }

    public function getName()
    {
        return 'money_transfer';
    }
}
