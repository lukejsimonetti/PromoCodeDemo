<?php
namespace Bundle\PublicSiteBundle\Component\Cart\Exception;


class Expired extends PromoCodeException
{
    public function __construct($message = "Promo code has expired.", $code = 0, PromoCodeException $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}