<?php
namespace Bundle\PublicSiteBundle\Component\Cart\TotalsGenerator\PromoCode;

use Bundle\PublicSiteBundle\Component\Cart\Exception\{
    NotYetValid, Expired, MinimumSubtotalRequired, MatchingCartItemSystemRequired
};

class FixedOnCart extends PromoCodeAbstract
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

        $amount = $this->getFixedAmountOfCart();
        $discountLine = $this->getDiscountLine(1, $amount);
        $normalizedLines[] = $discountLine;

        return $normalizedLines;
    }

    /**
     * @return float|int
     */
    public function getFixedAmountOfCart()
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