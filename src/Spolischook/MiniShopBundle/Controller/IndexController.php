<?php

namespace Spolischook\MiniShopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends Controller
{
    /**
     * @Template()
     * @Route("/")
     */
    public function indexAction()
    {
        return [];
    }
}
