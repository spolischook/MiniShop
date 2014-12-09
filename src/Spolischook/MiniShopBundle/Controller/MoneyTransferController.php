<?php

namespace Spolischook\MiniShopBundle\Controller;

use Spolischook\MiniShopBundle\Entity\Bank;
use Spolischook\MiniShopBundle\Entity\MoneyTransfer;
use Spolischook\MiniShopBundle\Form\Type\MoneyTransferType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("/money-transfers")
 */
class MoneyTransferController extends Controller
{
    /**
     * @Template(template="@MiniShop/MoneyTransfer/form.html.twig")
     * @Route("/new/banks/{id}")
     * @Method({"GET", "POST"})
     */
    public function formNewAction(Request $request, Bank $bank)
    {
        $moneyTransfer = new MoneyTransfer();
        $moneyTransfer->setFromBank($bank);

        $form = $this->createForm(new MoneyTransferType(), $moneyTransfer);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $modelTransfer = $form->getData();

            $this->getDoctrine()->getManager()->persist($modelTransfer);
            $this->getDoctrine()->getManager()->flush();

            $request->getSession()->getFlashBag()->add(
                'notice',
                'Your changes were saved!'
            );

            return $this->redirect($this->generateUrl('spolischook_minishop_index_index'));
        }

        return ['form' => $form->createView()];
    }

    /**
     * @Route("/{id}")
     * @Method({"DELETE"})
     */
    public function deleteAction(MoneyTransfer $moneyTransfer)
    {
        $this->getDoctrine()->getManager()->remove($moneyTransfer);
        $this->getDoctrine()->getManager()->flush();

        return JsonResponse::create();
    }
}
