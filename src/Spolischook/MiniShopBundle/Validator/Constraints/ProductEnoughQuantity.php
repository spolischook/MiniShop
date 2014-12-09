<?php

namespace Spolischook\MiniShopBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class ProductEnoughQuantity extends Constraint
{
    public $message = 'you_cant_order_more_then';

    public function validatedBy()
    {
        return 'product_enough_quantity';
    }
}
