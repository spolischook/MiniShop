<?php

namespace Spolischook\MiniShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * MoneyTransfer
 *
 * @ORM\Table(name="money_transfer")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 */
class MoneyTransfer
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
     * @ORM\Column(name="from_account", type="string", length=255)
     * @Assert\Choice(choices = {"card", "cash"}, message = "Allowed 'card' or 'cash'")
     */
    private $fromAccount;

    /**
     * @var string
     *
     * @ORM\Column(name="to_account", type="string", length=255)
     * @Assert\Choice(choices = {"card", "cash"}, message = "Allowed 'card' or 'cash'")
     */
    private $toAccount;

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
     * @ORM\Column(name="comment", type="string", length=255)
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set fromAccount
     *
     * @param string $fromAccount
     * @return MoneyTransfer
     */
    public function setFromAccount($fromAccount)
    {
        $this->fromAccount = $fromAccount;

        return $this;
    }

    /**
     * Get fromAccount
     *
     * @return string 
     */
    public function getFromAccount()
    {
        return $this->fromAccount;
    }

    /**
     * Set toAccount
     *
     * @param string $toAccount
     * @return MoneyTransfer
     */
    public function setToAccount($toAccount)
    {
        $this->toAccount = $toAccount;

        return $this;
    }

    /**
     * Get toAccount
     *
     * @return string 
     */
    public function getToAccount()
    {
        return $this->toAccount;
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
}
