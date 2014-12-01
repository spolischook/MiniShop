<?php

namespace Spolischook\MiniShopBundle\EventListener;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Spolischook\MiniShopBundle\Entity\Order;

class OrderSubscriber implements EventSubscriber
{
    protected $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

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
        ];
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        $entityManager = $args->getEntityManager();

        if ($entity instanceof Order) {
            $entity->setId(md5(uniqid($this->token)));
        }
    }

    public function preUpdate(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        $entityManager = $args->getEntityManager();

        if ($entity instanceof Order) {

        }
    }
}
