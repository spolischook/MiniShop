<?php

namespace Spolischook\MiniShopBundle\EventListener;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Spolischook\MiniShopBundle\Entity\Bank;
use Spolischook\MiniShopBundle\Entity\Store;

class ProductSaleSubscriber implements EventSubscriber
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
        /** @var EntityManager $em */
        $em = $args->getEntityManager();

        if ('Spolischook\MiniShopBundle\Entity\ProductSale' === get_class($entity)) {
            /** @var Store $store */
            $store = $entity->getStore();
            /** @var Bank $bank */
            $bank = $entity->getBank();

            $store->setProductQuantity($store->getProductQuantity() - $entity->getQuantity());
            $bank->setTotal($bank->getTotal() + $entity->getPrice() * $entity->getQuantity());
        }
    }

    public function preUpdate(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        $em = $args->getEntityManager();
        $uow = $em->getUnitOfWork();

        if ('Spolischook\MiniShopBundle\Entity\ProductSale' === get_class($entity)) {
            $cs = $uow->getEntityChangeSet($entity);

            if (array_key_exists('quantity', $cs) || array_key_exists('price', $cs)) {
                /**
                 * Changes to associations of the updated entity are never allowed in preUpdate
                 * See this - http://doctrine-orm.readthedocs.org/en/latest/reference/events.html#preupdate
                 */
                throw new \Exception('Now we can\'t update this');
            }

//            /** @var Store $store */
//            $store = $entity->getStore();
//            /** @var Bank $bank */
//            $bank = $entity->getBank();
//
//            if (array_key_exists('quantity', $cs) && array_key_exists('price', $cs)) {
//                $store->setProductQuantity(
//                    $store->getProductQuantity()
//                    - $cs['quantity'][0]
//                    + $cs['quantity'][1]
//                );
//                $bank->setTotal(
//                    $bank->getTotal()
//                    - $cs['quantity'][0] * $cs['price'][0]
//                    + $cs['quantity'][1] * $cs['price'][1]
//                );
//
//                $em->persist($store);
//                $em->persist($bank);
//                $uow->recomputeSingleEntityChangeSet($em->getClassMetadata(get_class($store)), $store);
//                $uow->recomputeSingleEntityChangeSet($em->getClassMetadata(get_class($bank)), $bank);
//            } elseif (array_key_exists('quantity', $cs)) {
//                $store->setProductQuantity(
//                    $store->getProductQuantity()
//                    - $cs['quantity'][0]
//                    + $cs['quantity'][1]
//                );
//                $bank->setTotal(
//                    $bank->getTotal()
//                    - $cs['quantity'][0] * $entity->getPrice()
//                    + $cs['quantity'][1] * $entity->getPrice()
//                );
//
//                $em->persist($store);
//                $em->persist($bank);
//                $uow->recomputeSingleEntityChangeSet($em->getClassMetadata(get_class($store)), $store);
//                $uow->recomputeSingleEntityChangeSet($em->getClassMetadata(get_class($bank)), $bank);
//            } elseif (array_key_exists('price', $cs)) {
//                $bank->setTotal(
//                    $bank->getTotal()
//                    - $entity->getQuantity() * $cs['price'][0]
//                    + $entity->getQuantity() * $cs['price'][1]
//                );
//
//                $em->persist($bank);
//                $uow->recomputeSingleEntityChangeSet($em->getClassMetadata(get_class($bank)), $bank);
//            }
//
//            $meta = $em->getClassMetadata(get_class($entity));
//            $uow->recomputeSingleEntityChangeSet($meta, $entity);
        }
    }

    public function preRemove(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        /** @var EntityManager $em */
        $em = $args->getEntityManager();

        if ('Spolischook\MiniShopBundle\Entity\ProductSale' === get_class($entity)) {
            /** @var Store $store */
            $store = $entity->getStore();
            /** @var Bank $bank */
            $bank = $entity->getBank();

            $store->setProductQuantity($store->getProductQuantity() + $entity->getQuantity());
            $bank->setTotal($bank->getTotal() - $entity->getPrice() * $entity->getQuantity());
        }
    }
}
