<?php

namespace Spolischook\CalendarBundle\Controller;

use Spolischook\MiniShopBundle\Entity\Order;
use Spolischook\MiniShopBundle\Form\Type\OrderType;
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
        $form = $this->createForm(new OrderType(), new Order());
        $moneyCount = $this->getDoctrine()->getManager()->getRepository('MiniShopBundle:ProductSale')->getTotalCash();
        $calendarCount = $this->getDoctrine()->getManager()->getRepository('MiniShopBundle:Store')->getTotalInStores();

        return [
            'form' => $form->createView(),
            'moneyCount' => $moneyCount,
            'calendarCount' => $calendarCount,
        ];
    }
}
