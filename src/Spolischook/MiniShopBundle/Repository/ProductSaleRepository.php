<?php

namespace Spolischook\MiniShopBundle\Repository;

use Doctrine\ORM\EntityRepository;

class ProductSaleRepository extends EntityRepository
{
    public function getTotalSalesCount()
    {
        $dql = "SELECT SUM(ps.quantity) AS total FROM Spolischook\\MiniShopBundle\\Entity\\ProductSale ps WHERE ps.price > 0";

        return $this->getEntityManager()->createQuery($dql)->getSingleScalarResult();
    }

    public function getTotalGiftsCount()
    {
        $dql = "SELECT SUM(ps.quantity) AS total FROM Spolischook\\MiniShopBundle\\Entity\\ProductSale ps WHERE ps.price = 0";

        return $this->getEntityManager()->createQuery($dql)->getSingleScalarResult();
    }

    public function getTotalCash()
    {
        $dql = "SELECT SUM(ps.quantity * ps.price) AS total FROM Spolischook\\MiniShopBundle\\Entity\\ProductSale ps WHERE ps.methodOfPayment = 'cash'";

        return $this->getEntityManager()->createQuery($dql)->getSingleScalarResult();
    }

    public function getTotalCard()
    {
        $dql = "SELECT SUM(ps.quantity * ps.price) AS total FROM Spolischook\\MiniShopBundle\\Entity\\ProductSale ps WHERE ps.methodOfPayment = 'card'";

        return $this->getEntityManager()->createQuery($dql)->getSingleScalarResult();
    }
}
