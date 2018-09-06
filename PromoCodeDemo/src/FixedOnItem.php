<?php
namespace Bundle\PublicSiteBundle\Component\Cart\TotalsGenerator\PromoCode;


class FixedOnItem extends PromoCodeAbstract
{
    public $qtyOfMatchingCatalogItem = 0;

    /**
     * @param $normalizedLines
     * @return array
     * @throws \Doctrine\ORM\EntityNotFoundException
     * @throws \Exception
     */
    public function apply($normalizedLines)
    {
        $this->runErrorFilter($normalizedLines);

        $this->calculateQtyOfMatchingCatalogItem($normalizedLines);
        $amount = $this->getFixedOnItemAmount();
        $discountLine = $this->getDiscountLine($this->qtyOfMatchingCatalogItem, $amount);
        $normalizedLines[] = $discountLine;

        return $normalizedLines;
    }

    /**
     * @param $normalizedLines
     */
    public function calculateQtyOfMatchingCatalogItem($normalizedLines)
    {
        $this->qtyOfMatchingCatalogItem = 0;

        foreach($normalizedLines as $line){
            if($line['catalog_item_id'] == $this->config()['rules']['catalog_item_id']){
                $this->qtyOfMatchingCatalogItem++;
            }
        }
    }

    /**
     * @return float|int
     */
    public function getFixedOnItemAmount()
    {
        return $this->config()['action']['amount'];
    }

    /**
     * @param $normalizedLines
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