<?php

namespace Bundle\SchemaBundle\Entity;

/**
 * CatalogItem
 */
class CatalogItem
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $itemCode;

    /**
     * @var string
     */
    private $label;

    /**
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $price = "0.00";

    /**
     * @var string
     */
    private $renewalPrice = "0.00";

    /**
     * @var string
     */
    private $shipping = '0.00';

    /**
     * @var string
     */
    private $taxable = '0.00';

    /**
     * @var integer
     */
    private $isActive = 1;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $products;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $invoiceLines;

    /**
     * @var CatalogItemType
     */
    private $catalogItemType;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $promoCodes;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->products = new \Doctrine\Common\Collections\ArrayCollection();
        $this->invoiceLines = new \Doctrine\Common\Collections\ArrayCollection();
        $this->promoCodes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->cartItems = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set itemCode
     *
     * @param string $itemCode
     *
     * @return CatalogItem
     */
    public function setItemCode($itemCode)
    {
        $this->itemCode = $itemCode;

        return $this;
    }

    /**
     * Get itemCode
     *
     * @return string
     */
    public function getItemCode()
    {
        return $this->itemCode;
    }

    /**
     * Set label
     *
     * @param string $label
     *
     * @return CatalogItem
     */
    public function setLabel($label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * Get label
     *
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return CatalogItem
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set price
     *
     * @param string $price
     *
     * @return CatalogItem
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set shipping
     *
     * @param string $shipping
     *
     * @return CatalogItem
     */
    public function setShipping($shipping)
    {
        $this->shipping = $shipping;

        return $this;
    }

    /**
     * Get shipping
     *
     * @return string
     */
    public function getShipping()
    {
        return $this->shipping;
    }

    /**
     * Set taxable
     *
     * @param string $taxable
     *
     * @return CatalogItem
     */
    public function setTaxable($taxable)
    {
        $this->taxable = $taxable;

        return $this;
    }

    /**
     * Get taxable
     *
     * @return string
     */
    public function getTaxable()
    {
        return $this->taxable;
    }

    /**
     * Set isActive
     *
     * @param integer $isActive
     *
     * @return CatalogItem
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return integer
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * Add product
     *
     * @param \Bundle\SchemaBundle\Entity\Product $product
     *
     * @return CatalogItem
     */
    public function addProduct(\Bundle\SchemaBundle\Entity\Product $product)
    {
        $this->products[] = $product;

        return $this;
    }

    /**
     * Remove product
     *
     * @param \Bundle\SchemaBundle\Entity\Product $product
     */
    public function removeProduct(\Bundle\SchemaBundle\Entity\Product $product)
    {
        $this->products->removeElement($product);
    }

    /**
     * Get products
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProducts()
    {
        return $this->products;
    }



    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getInvoiceLines()
    {
        return $this->invoiceLines;
    }

    /**
     * Add invoiceLine
     *
     * @param \Bundle\SchemaBundle\Entity\InvoiceLine $invoiceLine
     *
     * @return CatalogItem
     */
    public function addInvoiceLine(\Bundle\SchemaBundle\Entity\InvoiceLine $invoiceLine)
    {
        $this->invoiceLines[] = $invoiceLine;

        return $this;
    }

    /**
     * Remove invoiceLine
     *
     * @param \Bundle\SchemaBundle\Entity\InvoiceLine $invoiceLine
     */
    public function removeInvoiceLine(\Bundle\SchemaBundle\Entity\InvoiceLine $invoiceLine)
    {
        $this->invoiceLines->removeElement($invoiceLine);
    }

    /**
     * Set catalogItemType
     *
     * @param CatalogItemType $catalogItemType
     *
     * @return CatalogItem
     */
    public function setCatalogItemType(CatalogItemType $catalogItemType = null)
    {
        $this->catalogItemType = $catalogItemType;

        return $this;
    }

    /**
     * Get catalogItemType
     *
     * @return CatalogItemType
     */
    public function getCatalogItemType()
    {
        return $this->catalogItemType;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $conferenceType;


    /**
     * Add conferenceType
     *
     * @param \Bundle\SchemaBundle\Entity\ConferenceType $conferenceType
     *
     * @return CatalogItem
     */
    public function addConferenceType(\Bundle\SchemaBundle\Entity\ConferenceType $conferenceType)
    {
        $this->conferenceType[] = $conferenceType;

        return $this;
    }

    /**
     * Remove conferenceType
     *
     * @param \Bundle\SchemaBundle\Entity\ConferenceType $conferenceType
     */
    public function removeConferenceType(\Bundle\SchemaBundle\Entity\ConferenceType $conferenceType)
    {
        $this->conferenceType->removeElement($conferenceType);
    }

    /**
     * Get conferenceType
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getConferenceType()
    {
        return $this->conferenceType;
    }

    /**
     * Add promoCode
     *
     * @param PromoCode $promoCode
     *
     * @return CatalogItem
     */
    public function addPromoCode(PromoCode $promoCode)
    {
        $this->promoCodes[] = $promoCode;

        return $this;
    }

    /**
     * Remove promoCode
     *
     * @param PromoCode $promoCode
     */
    public function removePromoCode(PromoCode $promoCode)
    {
        $this->promoCodes->removeElement($promoCode);
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPromoCodes(): \Doctrine\Common\Collections\Collection
    {
        return $this->promoCodes;
    }


    public function getDependenciesList(){
        $ret = array();
        if(count($this->getInvoiceLines())){
            $ret [] = 'Invoices: '.count($this->getInvoiceLines());
        }
        return $ret;
    }

    public function dependenciesCount(){
        return count($this->getInvoiceLines() );

    }

    /**
     * Get renewalPrice
     *
     * @return string
     */
    public function getRenewalPrice()
    {
        return $this->renewalPrice;
    }

    /**
     * Set renewalPrice
     *
     * @param string $renewalPrice
     * @return CatalogItem
     */
    public function setRenewalPrice($renewalPrice)
    {
        $this->renewalPrice = $renewalPrice;


        return $this;
    }

    function __toString()
    {
        return $this->getLabel();
    }

}
