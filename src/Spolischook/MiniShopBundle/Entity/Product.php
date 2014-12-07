<?php

namespace Spolischook\MiniShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Product
 *
 * @ORM\Table(name="product")
 * @ORM\Entity()
 */
class Product
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
     * @ORM\Column(name="price", type="integer")
     */
    private $price;

    /**
     * @var
     *
     * @ORM\OneToMany(targetEntity="Spolischook\MiniShopBundle\Entity\Store", mappedBy="product")
     */
    private $stores;


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
     * @return Product
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
     * Set price
     *
     * @param integer $price
     * @return Product
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
     * Constructor
     */
    public function __construct()
    {
        $this->stores = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add stores
     *
     * @param \Spolischook\MiniShopBundle\Entity\Store $stores
     * @return Product
     */
    public function addStore(\Spolischook\MiniShopBundle\Entity\Store $stores)
    {
        $this->stores[] = $stores;

        return $this;
    }

    /**
     * Remove stores
     *
     * @param \Spolischook\MiniShopBundle\Entity\Store $stores
     */
    public function removeStore(\Spolischook\MiniShopBundle\Entity\Store $stores)
    {
        $this->stores->removeElement($stores);
    }

    /**
     * Get stores
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getStores()
    {
        return $this->stores;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return Product
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

    public function __toString()
    {
        return $this->getTitle();
    }
}
