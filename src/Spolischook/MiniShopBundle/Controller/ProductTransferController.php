<?php

namespace Spolischook\MiniShopBundle\Controller;

use Spolischook\MiniShopBundle\Form\Type\ProductTransferType;
use Spolischook\MiniShopBundle\Repository\StoreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Spolischook\MiniShopBundle\Entity\ProductTransfer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * @Route("/product-transfers")
 */
class ProductTransferController extends Controller
{
    /**
     * @Template(template="@MiniShop/ProductTransfer/form.html.twig")
     * @Route("/stores/{slug}")
     * @Method({"GET", "POST"})
     */
    public function formNewAction(Request $request, $slug)
    {
        $storeFrom = $this->getStoreRepository()->findOneBySlug($slug);

        $productTransfer = new ProductTransfer();
        $productTransfer->setStoreFrom($storeFrom);

        $form = $this->createForm(new ProductTransferType(), $productTransfer);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $productTransfer = $form->getData();

            $this->getDoctrine()->getManager()->persist($productTransfer);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirect($this->get('router')->generate('spolischook_minishop_index_index'));
        }

        return ['form' => $form->createView()];
    }

    /**
     * @Template(template="@MiniShop/ProductTransfer/form.html.twig")
     * @Route("/{id}")
     * @Method({"GET", "POST"})
     * @todo implement this
     */
    public function formEditAction(Request $request, ProductTransfer $productTransfer)
    {
        $request->getSession()->getFlashBag()->add(
            'error',
            'this_feature_is_not_available'
        );

        return $this->redirect($this->get('router')->generate('spolischook_minishop_index_index'));

        $form = $this->createForm(new ProductTransferType(), $productTransfer);
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
    public function deleteAction(ProductTransfer $productTransfer)
    {
        $this->getDoctrine()->getManager()->remove($productTransfer);
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
}
