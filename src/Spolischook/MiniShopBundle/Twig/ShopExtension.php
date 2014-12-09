<?php

namespace Spolischook\MiniShopBundle\Twig;

use Spolischook\MiniShopBundle\Entity\ProductMovingInterface;
use Symfony\Bundle\FrameworkBundle\Routing\Router;

class ShopExtension extends \Twig_Extension
{
    /** @var Router */
    protected $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    /**
     * Returns a list of functions to add to the existing list.
     *
     * @return array An array of functions
     */
    function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('getIconName', [$this, 'getIconName']),
        );
    }

    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('getClassName', array($this, 'getClassName')),
        );
    }

    public function getClassName(ProductMovingInterface $productMoving)
    {
        return strtolower(array_pop(explode('\\', get_class($productMoving))));
    }

    public function getIconName(ProductMovingInterface $productMoving)
    {
        switch (get_class($productMoving)) {
            case 'Spolischook\MiniShopBundle\Entity\ProductSale':
                if (0 == $productMoving->getPrice()) {
                    return 'gift';
                } else {
                    return 'shopping-cart';
                }

                break;
            case 'Spolischook\MiniShopBundle\Entity\ProductTransfer':
                return 'transfer';
        }
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return "shop_extension";
    }
}
