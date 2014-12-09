<?php

namespace Spolischook\MiniShopBundle\Controller;

use Doctrine\ORM\EntityRepository;
use Spolischook\MiniShopBundle\Entity\ProductSale;
use Spolischook\MiniShopBundle\Form\Type\ProductSaleType;
use Spolischook\MiniShopBundle\Repository\StoreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * @Route("/product-sales")
 */
class ProductSaleController extends Controller
{
    /**
     * @Template(template="@MiniShop/ProductSale/form.html.twig")
     * @Route("/stores/{slug}")
     * @Method({"GET", "POST"})
     */
    public function formNewAction(Request $request, $slug)
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
     * @Template(template="@MiniShop/ProductSale/form.html.twig")
     * @Route("/{id}")
     * @Method({"GET", "POST"})
     * @todo implement this
     */
    public function formEditAction(Request $request, ProductSale $productSale)
    {
        $request->getSession()->getFlashBag()->add(
            'error',
            'this_feature_is_not_available'
        );

        return $this->redirect($this->get('router')->generate('spolischook_minishop_index_index'));

        $product = $this->getProductRepository()->findOneBy([]);
        $form = $this->createForm(new ProductSaleType($product), $productSale);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirect($this->get('router')->generate('spolischook_minishop_index_index'));
        }

        return ['form' => $form->createView()];
    }

    /**
     * @Route("/{id}")
     * @Method({"DELETE"})
     */
    public function deleteAction(ProductSale $productSale)
    {
        $this->getDoctrine()->getManager()->remove($productSale);
        $this->getDoctrine()->getManager()->flush();

        return JsonResponse::create();
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
