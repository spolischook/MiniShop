<?php

namespace Spolischook\MiniShopBundle\Controller;

use Spolischook\MiniShopBundle\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class IndexController extends Controller
{
    /**
     * @Template()
     * @Route("/")
     * @Method({"GET"})
     */
    public function indexAction()
    {
        $stores         = $this->getDoctrine()->getManager()->getRepository('MiniShopBundle:Store')->findAll();
        $totalInStores  = $this->getDoctrine()->getManager()->getRepository('MiniShopBundle:Store')->getTotalInStores();
        $totalSales     = $this->getDoctrine()->getManager()->getRepository('MiniShopBundle:ProductSale')->getTotalSalesCount();
        $totalGifts     = $this->getDoctrine()->getManager()->getRepository('MiniShopBundle:ProductSale')->getTotalGiftsCount();
        $cashBank      = $this->getDoctrine()->getManager()->getRepository('MiniShopBundle:Bank')->findOneByType('cash');
        $cardBank      = $this->getDoctrine()->getManager()->getRepository('MiniShopBundle:Bank')->findOneByType('card');

        return [
            'stores'        => $stores,
            'totalInStores' => $totalInStores,
            'totalSales'    => $totalSales,
            'totalGifts'    => $totalGifts,
            'cashBank'      => $cashBank,
            'cardBank'      => $cardBank,
            'product'       => $this->getDoctrine()->getManager()->getRepository('MiniShopBundle:Product')->findAll()[0],
        ];
    }
}
