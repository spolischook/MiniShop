<?php

namespace Spolischook\MiniShopBundle\Form\Type;

use Spolischook\MiniShopBundle\Entity\Countries;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class OrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('country', 'country', [
                'preferred_choices' => ['UA', 'US', 'CA', 'DE', 'AU'],
                'data' => 'UA',
            ])
            ->add('address')
            ->add('phone')
            ->add('quantity')
            ->add('comment')
        ;

        $builder->addEventListener(FormEvents::POST_SET_DATA, function (FormEvent $event) {
            $order = $event->getData();

            if ('UA' == $order->getCountry()) {
                $order->setCurrency('UAH');
                $order->setAmount($order->getQuantity() * 120);
            } else {
                $order->setCurrency('USD');
                $order->setAmount($order->getQuantity() * 10 + 5);
            }
        });
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
