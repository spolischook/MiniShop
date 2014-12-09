<?php

namespace Spolischook\MiniShopBundle\Entity;

interface ItemMovingInterface
{
    public function getId();

    /**
     * @return string
     */
    public function getFrom();

    /**
     * @return string
     */
    public function getTo();

    /**
     * @return integer
     */
    public function getQuantity();

    /**
     * @return \DateTime
     */
    public function getCreatedAt();

    public function getRouterChunkClassName();
}
