<?php

namespace Spolischook\MiniShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Store
 *
 * @ORM\Table(name="store")
 * @ORM\Entity(repositoryClass="Spolischook\MiniShopBundle\Repository\StoreRepository")
 */
class Store
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @Gedmo\Slug(fields={"title"})
     * @ORM\Column(name="slug", type="string", length=255)
     */
    private $slug;

    /**
     * @var integer
     *
     * @ORM\Column(name="product_quantity", type="integer", nullable=true)
     */
    private $productQuantity;

    /**
     * @var
     *
     * @ORM\ManyToOne(targetEntity="Spolischook\MiniShopBundle\Entity\Product", inversedBy="stores")
     */
    private $product;

    /**
     * @var \Spolischook\MiniShopBundle\Entity\ProductSale
     *
     * @ORM\OneToMany(targetEntity="Spolischook\MiniShopBundle\Entity\ProductSale", mappedBy="store")
     */
    private $productSales;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->productSales = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Store
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set productQuantity
     *
     * @param integer $productQuantity
     * @return Store
     */
    public function setProductQuantity($productQuantity)
    {
        if ($productQuantity < 0) {
            throw new \Exception('Quantity can\'t be less then zero');
        }

        $this->productQuantity = $productQuantity;

        return $this;
    }

    /**
     * Get productQuantity
     *
     * @return integer 
     */
    public function getProductQuantity()
    {
        return $this->productQuantity;
    }

    /**
     * Set product
     *
     * @param \Spolischook\MiniShopBundle\Entity\Product $product
     * @return Store
     */
    public function setProduct(\Spolischook\MiniShopBundle\Entity\Product $product = null)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get product
     *
     * @return \Spolischook\MiniShopBundle\Entity\Product 
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return Store
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Add productSales
     *
     * @param \Spolischook\MiniShopBundle\Entity\ProductSale $productSales
     * @return Store
     */
    public function addProductSale(\Spolischook\MiniShopBundle\Entity\ProductSale $productSales)
    {
        $this->productSales[] = $productSales;

        return $this;
    }

    /**
     * Remove productSales
     *
     * @param \Spolischook\MiniShopBundle\Entity\ProductSale $productSales
     */
    public function removeProductSale(\Spolischook\MiniShopBundle\Entity\ProductSale $productSales)
    {
        $this->productSales->removeElement($productSales);
    }

    /**
     * Get productSales
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getProductSales()
    {
        return $this->productSales;
    }

    /**
     * @return int
     */
    public function getGiftItemsCount()
    {
        $giftItems = 0;

        /** @var ProductSale $productSale */
        foreach ($this->getProductSales() as $productSale) {
            if ($productSale->getPrice() == 0) {
                $giftItems += $productSale->getQuantity();
            }
        }

        return $giftItems;
    }

    /**
     * @return int
     */
    public function getSalesItemsCount()
    {
        $salesItems = 0;

        /** @var ProductSale $productSale */
        foreach ($this->getProductSales() as $productSale) {
            if ($productSale->getPrice() > 0) {
                $salesItems += $productSale->getQuantity();
            }
        }

        return $salesItems;
    }

    public function __toString()
    {
        return $this->getTitle();
    }
}
