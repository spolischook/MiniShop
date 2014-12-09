<?php

namespace Spolischook\MiniShopBundle\EventListener;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Spolischook\MiniShopBundle\Entity\Bank;
use Spolischook\MiniShopBundle\Entity\ProductTransfer;
use Spolischook\MiniShopBundle\Entity\Store;

class MoneyTransferSubscriber implements EventSubscriber
{
    /**
     * Returns an array of events this subscriber wants to listen to.
     *
     * @return array
     */
    public function getSubscribedEvents()
    {
        return [
            'prePersist',
            'preUpdate',
            'preRemove',
        ];
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if ('Spolischook\MiniShopBundle\Entity\MoneyTransfer' === get_class($entity)) {
            /** @var Bank $fromBank */
            $fromBank = $entity->getFromBank();
            /** @var Bank $toBank */
            $toBank   = $entity->getToBank();

            $fromBank->setTotal($fromBank->getTotal() - $entity->getQuantity());
            $toBank->setTotal($toBank->getTotal() + $entity->getQuantity());
        }
    }

    public function preUpdate(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        $uow = $args->getEntityManager()->getUnitOfWork();
        $originalData = $uow->getOriginalEntityData($entity);

        if ('Spolischook\MiniShopBundle\Entity\MoneyTransfer' === get_class($entity)) {
            /**
             * Changes to associations of the updated entity are never allowed in preUpdate
             * See this - http://doctrine-orm.readthedocs.org/en/latest/reference/events.html#preupdate
             */
            throw new \Exception('Now we can\'t update this');
        }
    }

    public function preRemove(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if ('Spolischook\MiniShopBundle\Entity\MoneyTransfer' === get_class($entity)) {
            /** @var Bank $fromBank */
            $fromBank = $entity->getFromBank();
            /** @var Bank $toBank */
            $toBank   = $entity->getToBank();

            $fromBank->setTotal($fromBank->getTotal() + $entity->getQuantity());
            $toBank->setTotal($toBank->getTotal() - $entity->getQuantity());
        }
    }
}
