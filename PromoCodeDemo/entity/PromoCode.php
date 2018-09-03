<?php

namespace Bundle\SchemaBundle\Entity;

use Doctrine\Common\Collections\Collection;
use JMS\Serializer\Annotation\Groups;

/**
 * PromoCode
 */
class PromoCode
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @var \DateTime
     */
    private $startAt;

    /**
     * @var \DateTime
     */
    private $endAt;

    /**
     * @var string
     */
    private $config;

    /**
     * @var string
     */
    private $code;

    /**
     * @var string
     */
    private $label;

    /**
     * @var string
     */
    private $description;

    /*
     * @var bool
     */
    private $isActive;

    /**
     * @var CatalogItem
     */
    private $catalogItem;

    /**
     * @var Collection
     */
    private $carts;

    /**
     * PromoCode constructor.
     */
    public function __construct()
    {
        $this->carts = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Set Id
     *
     * @param int $id
     * @return PromoCode
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    /**
     * Set CreatedAt
     *
     * @param \DateTime $createdAt
     * @return PromoCode
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt;
    }

    /**
     * Set UpdatedAt
     *
     * @param \DateTime $updatedAt
     * @return PromoCode
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getStartAt()
    {
        return $this->startAt;
    }

    /**
     * Set StartAt
     *
     * @param \DateTime $startAt
     * @return PromoCode
     */
    public function setStartAt($startAt)
    {
        $this->startAt = $startAt;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getEndAt()
    {
        return $this->endAt;
    }

    /**
     * Set EndAt
     *
     * @param \DateTime $endAt
     * @return PromoCode
     */
    public function setEndAt($endAt)
    {
        $this->endAt = $endAt;

        return $this;
    }

    /**
     * @return string
     */
    public function getConfig(): string
    {
        return $this->config;
    }

    /**
     * Set Config
     *
     * @param string $config
     * @return PromoCode
     */
    public function setConfig($config)
    {
        $this->config = $config;

        return $this;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * Set Code
     *
     * @param string $code
     * @return PromoCode
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * @return string
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * Set Label
     *
     * @param string $label
     * @return PromoCode
     */
    public function setLabel($label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * Set Description
     *
     * @param string $description
     * @return PromoCode
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getIsActive(): bool
    {
        return $this->isActive;
    }

    /**
     * Set IsActive
     *
     * @param mixed $isActive
     * @return PromoCode
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * @return CatalogItem
     */
    public function getCatalogItem(): CatalogItem
    {
        return $this->catalogItem;
    }

    /**
     * Set CatalogItem
     *
     * @param CatalogItem $catalogItem
     * @return PromoCode
     */
    public function setCatalogItem($catalogItem)
    {
        $this->catalogItem = $catalogItem;

        return $this;
    }

    /**
     * Add cart
     *
     * @param Cart $cart
     *
     * return PromoCode
     */
    public function addCart(Cart $cart)
    {
        $this->carts[] = $cart;

        return $this;
    }

    /**
     * Remove cart
     *
     * @param Cart $cart
     */
    public function removeCart(Cart $cart)
    {
        $this->carts->removeElement($cart);
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCarts(): \Doctrine\Common\Collections\Collection
    {
        return $this->carts;
    }

}
