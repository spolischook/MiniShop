<?php

namespace Spolischook\MiniShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * ProductSales
 *
 * @ORM\Table(name="product_sale")
 * @ORM\Entity(repositoryClass="Spolischook\MiniShopBundle\Repository\ProductSaleRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class ProductSale implements ProductMovingInterface
{
    const CASH = 'cash';

    const CARD = 'card';

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \Spolischook\MiniShopBundle\Entity\Store
     *
     * @ORM\ManyToOne(targetEntity="Spolischook\MiniShopBundle\Entity\Store", inversedBy="productSales")
     */
    private $store;

    /**
     * @var string
     *
     * @ORM\Column(name="quantity", type="integer")
     */
    private $quantity;

    /**
     * @var integer
     *
     * @ORM\Column(name="price", type="integer")
     */
    private $price;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     * @Gedmo\Timestampable(on="create")
     */
    private $createdAt;

    /**
     * @var string
     *
     * @ORM\Column(name="comment", type="string", length=255, nullable=true)
     */
    private $comment;

    /**
     * @var string
     *
     * @ORM\Column(name="method_of_payment", type="string", length=255)
     */
    private $methodOfPayment;

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
     * Set quantity
     *
     * @param integer $quantity
     * @return ProductSale
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return integer
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set price
     *
     * @param integer $price
     * @return ProductSale
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return integer 
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return ProductSale
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set comment
     *
     * @param string $comment
     * @return ProductSale
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment
     *
     * @return string 
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set store
     *
     * @param \Spolischook\MiniShopBundle\Entity\Store $store
     * @return ProductSale
     */
    public function setStore(Store $store = null)
    {
        $this->store = $store;

        return $this;
    }

    /**
     * Get store
     *
     * @return \Spolischook\MiniShopBundle\Entity\Store 
     */
    public function getStore()
    {
        return $this->store;
    }

    /**
     * Set methodOfPayment
     *
     * @param string $methodOfPayment
     * @return ProductSale
     */
    public function setMethodOfPayment($methodOfPayment)
    {
        if (!in_array($methodOfPayment, ['cash', 'card'])) {
            throw new \Exception('Method must be "cash" or "card"');
        }

        $this->methodOfPayment = $methodOfPayment;

        return $this;
    }

    /**
     * Get methodOfPayment
     *
     * @return string
     */
    public function getMethodOfPayment()
    {
        return $this->methodOfPayment;
    }

    /**
     * @return string
     */
    public function getFrom()
    {
        return $this->getStore()->getTitle();
    }

    /**
     * @return string
     */
    public function getTo()
    {
        return $this->getComment();
    }

    /**
     * @ORM\PrePersist
     */
    public function updateStoresQuantity()
    {
        $this->getStore()->setProductQuantity($this->getStore()->getProductQuantity() - $this->getQuantity());
    }
}
