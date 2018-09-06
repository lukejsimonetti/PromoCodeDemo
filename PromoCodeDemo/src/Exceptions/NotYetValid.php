<?php
namespace Bundle\PublicSiteBundle\Component\Cart\Exception;


class NotYetValid extends PromoCodeException
{
    public function __construct($message = "Promo code not valid yet.", $code = 0, PromoCodeException $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}