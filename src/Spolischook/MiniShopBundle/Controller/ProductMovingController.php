<?php

namespace Spolischook\MiniShopBundle\Controller;

use Spolischook\MiniShopBundle\Entity\ItemMovingInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class ProductMovingController extends Controller
{
    /**
     * @Template()
     * @Route("/product-moving")
     * @Method({"GET"})
     */
    public function getAllMovingAction()
    {
        $productMovings = array_merge(
            $this->getDoctrine()->getManager()->getRepository('MiniShopBundle:ProductSale')->findAll(),
            $this->getDoctrine()->getManager()->getRepository('MiniShopBundle:ProductTransfer')->findAll(),
            $this->getDoctrine()->getManager()->getRepository('MiniShopBundle:MoneyTransfer')->findAll()
        );

        usort($productMovings, array($this, "compareDateTime"));

        return ['productMovings' => $productMovings];
    }

    public function compareDateTime(ItemMovingInterface $a, ItemMovingInterface $b)
    {
        if ($a->getCreatedAt() == $b->getCreatedAt()) {
            return 0;
        }

        return ($a->getCreatedAt() > $b->getCreatedAt()) ? +1 : -1;
    }
}
