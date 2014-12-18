<?php

namespace Spolischook\MiniShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * ProductSales
 *
 * @ORM\Table(name="product_sale")
 * @ORM\Entity(repositoryClass="Spolischook\MiniShopBundle\Repository\ProductSaleRepository")
 * @ORM\HasLifecycleCallbacks()
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 */
class ProductSale implements ItemMovingInterface
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
     * @var \Spolischook\MiniShopBundle\Entity\Store
     *
     * @ORM\ManyToOne(targetEntity="Spolischook\MiniShopBundle\Entity\Store", inversedBy="productSales", fetch="EAGER")
     */
    private $store;

    /**
     * @var integer
     *
     * @Assert\Type(type="integer")
     * @Assert\NotBlank()
     * @ORM\Column(name="quantity", type="integer")
     */
    private $quantity;

    /**
     * @var integer
     *
     * @Assert\Type(type="integer")
     * @Assert\NotBlank()
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
     * @var \DateTime
     *
     * @ORM\Column(name="deletedAt", type="datetime", nullable=true)
     */
    private $deletedAt;

    /**
     * @var string
     *
     * @ORM\Column(name="comment", type="string", length=255, nullable=true)
     */
    private $comment;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @Assert\Choice(callback = {"Spolischook\MiniShopBundle\Entity\Bank", "getAllowedTypes"}, message = "Allowed 'card' or 'cash'")
     * @ORM\ManyToOne(targetEntity="Spolischook\MiniShopBundle\Entity\Bank", inversedBy="salesTransactions", fetch="EAGER")
     */
    private $bank;

    /**
     * @var string
     * @deprecated
     * @ORM\Column(name="method_of_payment", type="string", length=255, nullable=true)
     */
    private $methodOfPayment = null;

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
     * Set bank
     *
     * @param \Spolischook\MiniShopBundle\Entity\Bank $bank
     * @return ProductSale
     */
    public function setBank(\Spolischook\MiniShopBundle\Entity\Bank $bank = null)
    {
        $this->bank = $bank;

        return $this;
    }

    /**
     * Get bank
     *
     * @return \Spolischook\MiniShopBundle\Entity\Bank 
     */
    public function getBank()
    {
        return $this->bank;
    }

    /**
     * Set methodOfPayment
     * @deprecated
     * @param string $methodOfPayment
     * @return ProductSale
     */
    public function setMethodOfPayment($methodOfPayment)
    {
        $this->methodOfPayment = $methodOfPayment;

        return $this;
    }

    /**
     * Get methodOfPayment
     * @deprecated
     * @return string 
     */
    public function getMethodOfPayment()
    {
        return $this->methodOfPayment;
    }

    /**
     * @return string
     */
    public function getRouterChunkClassName()
    {
        return 'productsale';
    }

    /**
     * Set deletedAt
     *
     * @param \DateTime $deletedAt
     * @return ProductSale
     */
    public function setDeletedAt($deletedAt)
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    /**
     * Get deletedAt
     *
     * @return \DateTime 
     */
    public function getDeletedAt()
    {
        return $this->deletedAt;
    }

    /**
     * @Assert\Callback
     */
    public function validateStoreQuantity(ExecutionContextInterface $context)
    {
        if ($this->getStore()->getProductQuantity() - $this->getQuantity() < 0) {
            $context->buildViolation('Not enough goods in a store')
                ->atPath('quantity')
                ->addViolation();
        }
    }
}
