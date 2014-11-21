<?php

namespace Spolischook\MiniShopBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Spolischook\MiniShopBundle\Entity\Store;

class StoreRepository extends EntityRepository
{
    public function getTotalInStores()
    {
        $dql = "SELECT SUM(s.productQuantity) AS total FROM Spolischook\\MiniShopBundle\\Entity\\Store s";

        return $this->getEntityManager()->createQuery($dql)->getSingleScalarResult();
    }

    public function findAllExceptOne(Store $store)
    {
        $qb = $this->createQueryBuilder('s');
        $qb->where('s.id != :identifier')->setParameter('identifier', $store->getId());

        return $qb->getQuery()->getResult();
    }
}
