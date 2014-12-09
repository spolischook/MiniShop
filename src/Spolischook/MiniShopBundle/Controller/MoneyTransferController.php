<?php

namespace Spolischook\MiniShopBundle\Controller;

use Spolischook\MiniShopBundle\Form\Type\MoneyTransferType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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
     * @Template()
     * @Route("/new")
     * @Method({"GET", "POST"})
     */
    public function formTransferAction(Request $request)
    {
        $form = $this->createForm(new MoneyTransferType());

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

    public function formEditAction()
    {

    }
}
