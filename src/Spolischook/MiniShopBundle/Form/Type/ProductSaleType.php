<?php

namespace Spolischook\MiniShopBundle\Form\Type;

use Spolischook\MiniShopBundle\Entity\Bank;
use Spolischook\MiniShopBundle\Entity\Countries;
use Spolischook\MiniShopBundle\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProductSaleType extends AbstractType
{
    protected $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('store', null, ['disabled' => true])
            ->add('product', 'entity', [
                'mapped' => false,
                'disabled' => true,
                'data' => $this->product,
                'class' => 'Spolischook\MiniShopBundle\Entity\Product'
            ])
            ->add('price')
            ->add('quantity')
            ->add('bank')
            ->add('comment')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Spolischook\MiniShopBundle\Entity\ProductSale',
        ));
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'product_sale';
    }
}
