<?php

namespace Spolischook\MiniShopBundle\Controller;

use Spolischook\MiniShopBundle\Entity\Store;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * @Route("/stores")
 */
class StoreController extends Controller
{
    /**
     * @Template()
     * @Route("/new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        if ($request->isMethod('POST')) {
            $store = new Store();
            $store
                ->setTitle($request->request->get('title'))
                ->setProduct($this->getDoctrine()->getManager()->getRepository('MiniShopBundle:Product')->find($request->request->get('product')))
            ;

            $this->getDoctrine()->getManager()->persist($store);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirect($this->get('router')->generate('spolischook_minishop_index_index'));
        }

        return ['products' => $this->getDoctrine()->getManager()->getRepository('MiniShopBundle:Product')->findAll()];
    }

    /**
     * @Template()
     * @Route("/{slug}")
     * @Method({"GET"})
     */
    public function getAction($slug)
    {
        return ['store' => $this->getDoctrine()->getManager()->getRepository('MiniShopBundle:Store')->findOneBySlug($slug)];
    }
}
