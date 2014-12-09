<?php

namespace Spolischook\MiniShopBundle\Validator\Constraints;

use Spolischook\MiniShopBundle\Repository\StoreRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class ProductEnoughQuantityValidator extends ConstraintValidator
{
    protected $storeRepository;

    public function __construct(StoreRepository $storeRepository)
    {
        $this->storeRepository = $storeRepository;
    }

    public function validate($value, Constraint $constraint)
    {
        $totalInStores  = $this->storeRepository->getTotalInStores();

        if ($totalInStores < $value) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('%number%', $totalInStores)
                ->addViolation();
        }
    }
}
