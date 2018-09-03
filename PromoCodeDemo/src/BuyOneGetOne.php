<?php

namespace Bundle\PublicSiteBundle\Component\Cart\TotalsGenerator\PromoCode;

use Bundle\SchemaBundle\Entity\CatalogItem;
use Bundle\PublicSiteBundle\Component\Cart\Exception\{
    NotYetValid, Expired, MinimumSubtotalRequired, MatchingCartItemSystemRequired
};

class BuyOneGetOne extends PromoCodeAbstract
{
    /**
     * @param $normalizedLines
     * @return array
     * @throws \Doctrine\ORM\EntityNotFoundException
     * @throws \Exception
     */
    public function apply($normalizedLines)
    {
        $this->runErrorFilter($normalizedLines);

        $qualifyingItemsCount = $this->qualifyingItemsCount($normalizedLines, $this->getPromoCodeCatalogItemID());

        if (!$qualifyingItemsCount) return $normalizedLines;

        $uid = $this->generateUID();
        $discountQty = 0;

        foreach($normalizedLines as $k => $line){
            if($qualifyingItemsCount == $discountQty) break;

            if ($line['catalog_item_id'] == $this->getPromoCodeCatalogItemID() && !$line['is_discount_line']) {
                $discountQty++;
                $normalizedLines[$k]['discount_uid'] = $uid;
            }
        }

        /** @var CatalogItem $catalogItem */
        $catalogItem = $this->getCatalogItem($this->config()['action']['discount_catalog_item_id']);

        $discountLine = [
            'catalog_item_id' => $catalogItem->getId(),
            'is_discount_line' => true,
            'item_code' => $catalogItem->getItemCode(),
            'description' => $catalogItem->getDescription(),
            'quantity' => $discountQty,
            'price' => -($this->config()['action']['amount']),
            'discount_uid' => $uid,
            'is_removable' => true
        ];
        $normalizedLines[] = $discountLine;

        return $normalizedLines;
    }

    public function getPromoCodeCatalogItemID()
    {
        return $this->config()['rules']['catalog_item_id'];
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function runErrorFilter($normalizedLines)
    {
        $this->calculateCartSubtotal($normalizedLines);

        if(!$this->linesHaveAtLeastOneCorrectSystem($normalizedLines)){
            throw new MatchingCartItemSystemRequired($this->config()['rules']['system']);
        }

        if(!$this->linesHaveMinimumSubtotal()){
            throw new MinimumSubtotalRequired();
        }

        if($this->promoCodeIsInTheFuture()){
            throw new NotYetValid();
        }

        if($this->promoCodeIsExpired()){
            throw new Expired();
        }

        return;
    }
}