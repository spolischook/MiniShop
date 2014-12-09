<?php

namespace Spolischook\MiniShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * MoneyTransfer
 *
 * @ORM\Table(name="money_transfer")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 */
class MoneyTransfer implements ItemMovingInterface
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
     * @ORM\ManyToOne(targetEntity="Spolischook\MiniShopBundle\Entity\Bank")
     * @Assert\NotBlank()
     */
    private $fromBank;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="Spolischook\MiniShopBundle\Entity\Bank")
     * @Assert\NotBlank()
     */
    private $toBank;

    /**
     * @var string
     *
     * @ORM\Column(name="quantity", type="integer")
     * @Assert\GreaterThan(value=0)
     */
    private $quantity;

    /**
     * @var string
     *
     * @ORM\Column(name="comment", type="string", length=255, nullable=true)
     */
    private $comment;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdAt", type="datetime")
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return MoneyTransfer
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
     * @return MoneyTransfer
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
     * Set quantity
     *
     * @param integer $quantity
     * @return MoneyTransfer
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
     * Set deletedAt
     *
     * @param \DateTime $deletedAt
     * @return MoneyTransfer
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
     * Set fromBank
     *
     * @param \Spolischook\MiniShopBundle\Entity\Bank $fromBank
     * @return MoneyTransfer
     */
    public function setFromBank(\Spolischook\MiniShopBundle\Entity\Bank $fromBank = null)
    {
        $this->fromBank = $fromBank;

        return $this;
    }

    /**
     * Get fromBank
     *
     * @return \Spolischook\MiniShopBundle\Entity\Bank 
     */
    public function getFromBank()
    {
        return $this->fromBank;
    }

    /**
     * Set toBank
     *
     * @param \Spolischook\MiniShopBundle\Entity\Bank $toBank
     * @return MoneyTransfer
     */
    public function setToBank(\Spolischook\MiniShopBundle\Entity\Bank $toBank = null)
    {
        $this->toBank = $toBank;

        return $this;
    }

    /**
     * Get toBank
     *
     * @return \Spolischook\MiniShopBundle\Entity\Bank 
     */
    public function getToBank()
    {
        return $this->toBank;
    }

    /**
     * @return string
     */
    public function getFrom()
    {
        return 'Bank type: ' . $this->getFromBank()->getType();
    }

    /**
     * @return string
     */
    public function getTo()
    {
        return 'Bank type: ' . $this->getToBank()->getType();
    }

    public function getRouterChunkClassName()
    {
        return 'moneytransfer';
    }

    /**
     * @Assert\Callback
     */
    public function validateEqualBank(ExecutionContextInterface $context)
    {
        if ($this->getFromBank()->getId() === $this->getToBank()->getId()) {
            $context->buildViolation('you_cant_move_money_to_the_same_bank')
                ->atPath('toBank')
                ->addViolation();
        }
    }

    /**
     * @Assert\Callback
     */
    public function validateEnoughMoney(ExecutionContextInterface $context)
    {
        if ($this->getFromBank()->getTotal() - $this->getQuantity() < 0) {
            $context->buildViolation('you_cant_move_more_then', ['%bankTotal%' => $this->getFromBank()->getTotal()])
                ->atPath('quantity')
                ->addViolation();
        }
    }
}
