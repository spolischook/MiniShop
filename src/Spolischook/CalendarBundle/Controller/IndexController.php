<?php

namespace Spolischook\CalendarBundle\Controller;

use Spolischook\MiniShopBundle\Entity\Order;
use Spolischook\MiniShopBundle\Form\Type\OrderType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class IndexController extends Controller
{
    /**
     * @Template()
     * @Route("/")
     * @Method({"GET", "POST"})
     * @param Request $request
     * @return Response
     */
    public function indexAction(Request $request)
    {
        $form = $this->createForm(new OrderType(), new Order());
        $totalCash      = $this->getDoctrine()->getManager()->getRepository('MiniShopBundle:Bank')->findOneByType('cash')->getTotal();
        $totalCard      = $this->getDoctrine()->getManager()->getRepository('MiniShopBundle:Bank')->findOneByType('card')->getTotal();
        $calendarCount = $this->getDoctrine()->getManager()->getRepository('MiniShopBundle:Store')->getTotalInStores();

        $form->handleRequest($request);

        if ($form->isValid()) {
            $order = $form->getData();
//var_dump($order); exit;
            $this->getDoctrine()->getManager()->persist($order);
            $this->getDoctrine()->getManager()->flush();

            //redirect
            exit;
        }

        return [
            'form' => $form->createView(),
            'moneyCount' => $totalCash + $totalCard,
            'calendarCount' => $calendarCount,
        ];
    }
}
