<?php

namespace Spolischook\MiniShopBundle\Controller;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Spolischook\MiniShopBundle\Entity\ProductSale;
use Spolischook\MiniShopBundle\Entity\ProductTransfer;
use Spolischook\MiniShopBundle\Entity\Store;
use Spolischook\MiniShopBundle\Form\Type\ProductSaleType;
use Spolischook\MiniShopBundle\Repository\StoreRepository;
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
     * @Route("/transfer/{slug}")
     * @Method({"GET", "POST"})
     */
    public function transferAction(Request $request, $slug)
    {
        $storeFrom = $this->getStoreRepository()->findOneBySlug($slug);

        if ($request->isMethod('POST')) {
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

        return ['stores' => $this->getStoreRepository()->findAllExceptOne($storeFrom), 'storeFrom' => $storeFrom];
    }

    /**
     * @Template()
     * @Route("/sales/{slug}")
     * @Method({"GET", "POST"})
     */
    public function saleAction(Request $request, $slug)
    {
        $store = $this->getStoreRepository()->findOneBySlug($slug);
        $product = $this->getProductRepository()->findOneBy([]);
        $productSale = new ProductSale();
        $productSale->setStore($store);

        $form = $this->createForm(new ProductSaleType($product), $productSale);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $this->getDoctrine()->getManager()->persist($productSale);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirect($this->get('router')->generate('spolischook_minishop_index_index'));
        }

        return ['form' => $form->createView()];
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

    /**
     * @return EntityManager
     */
    protected function getEm()
    {
        return $this->getDoctrine()->getManager();
    }

    /**
     * @return StoreRepository
     */
    protected function getStoreRepository()
    {
        return $this->getDoctrine()->getManager()->getRepository('MiniShopBundle:Store');
    }

    /**
     * @return EntityRepository
     */
    protected function getProductRepository()
    {
        return $this->getDoctrine()->getManager()->getRepository('MiniShopBundle:Product');
    }
}
