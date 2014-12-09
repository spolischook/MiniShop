<?php

namespace Spolischook\MiniShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Bank
 *
 * @ORM\Table(name="bank")
 * @ORM\Entity
 */
class Bank
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
     * @var string
     *
     * @Assert\Choice(callback = "getAllowedTypes")
     * @ORM\Column(name="type", type="string", unique=true)
     */
    private $type;

    /**
     * @var integer
     *
     * @ORM\Column(name="total", type="integer")
     */
    private $total;

    /**
     * @var ProductSale
     *
     * @ORM\OneToMany(targetEntity="Spolischook\MiniShopBundle\Entity\ProductSale", mappedBy="bank")
     */
    private $salesTransactions;

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
     * Set type
     *
     * @param string $type
     * @return Bank
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set total
     *
     * @param integer $total
     * @return Bank
     */
    public function setTotal($total)
    {
        $this->total = $total;

        return $this;
    }

    /**
     * Get total
     *
     * @return integer 
     */
    public function getTotal()
    {
        return $this->total;
    }

    public static function getAllowedTypes()
    {
        return array(
            self::CASH => self::CASH,
            self::CARD => self::CARD,
        );
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->salesTransactions = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add salesTransactions
     *
     * @param \Spolischook\MiniShopBundle\Entity\ProductSale $salesTransactions
     * @return Bank
     */
    public function addSalesTransaction(\Spolischook\MiniShopBundle\Entity\ProductSale $salesTransactions)
    {
        $this->salesTransactions[] = $salesTransactions;

        return $this;
    }

    /**
     * Remove salesTransactions
     *
     * @param \Spolischook\MiniShopBundle\Entity\ProductSale $salesTransactions
     */
    public function removeSalesTransaction(\Spolischook\MiniShopBundle\Entity\ProductSale $salesTransactions)
    {
        $this->salesTransactions->removeElement($salesTransactions);
    }

    /**
     * Get salesTransactions
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSalesTransactions()
    {
        return $this->salesTransactions;
    }

    public function __toString()
    {
        return $this->getType();
    }
}
