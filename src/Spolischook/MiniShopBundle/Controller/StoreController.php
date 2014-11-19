<?php

namespace Spolischook\MiniShopBundle\Controller;

use Spolischook\MiniShopBundle\Entity\ProductTransfer;
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
                ->setProduct($this->getProductRepository()->find($request->request->get('product')))
            ;

            $this->getDoctrine()->getManager()->persist($store);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirect($this->get('router')->generate('spolischook_minishop_index_index'));
        }

        return ['products' => $this->getProductRepository()->findAll()];
    }

    /**
     * @Template()
     * @Route("/transfer")
     * @Method({"GET", "POST"})
     */
    public function transferAction(Request $request)
    {
        if ($request->isMethod('POST')) {
            $storeFrom = $this->getStoreRepository()->find($request->request->get('from'));
            $storeTo   = $this->getStoreRepository()->find($request->request->get('to'));
            $quantity  = $request->request->get('quantity');

            if ($storeFrom->getId() === $storeTo->getId()) {
                throw new \Exception('You can\'t move product to the same store');
            }

            $productTransfer = new ProductTransfer();
            $productTransfer
                ->setStoreFrom($storeFrom)
                ->setStoreTo($storeTo)
                ->setQuantity($quantity)
            ;

            $this->getDoctrine()->getManager()->persist($productTransfer);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirect($this->get('router')->generate('spolischook_minishop_index_index'));
        }

        return ['stores' => $this->getStoreRepository()->findAll()];
    }

    /**
     * @Template()
     * @Route("/{slug}")
     * @Method({"GET"})
     */
    public function getAction($slug)
    {
        return ['store' => $this->getStoreRepository()->findOneBySlug($slug)];
    }

    protected function getEm()
    {
        return $this->getDoctrine()->getManager();
    }

    protected function getStoreRepository()
    {
        return $this->getDoctrine()->getManager()->getRepository('MiniShopBundle:Store');
    }

    protected function getProductRepository()
    {
        return $this->getDoctrine()->getManager()->getRepository('MiniShopBundle:Product');
    }
}
