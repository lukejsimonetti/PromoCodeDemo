<?php
namespace Bundle\PublicSiteBundle\Component\Cart\Exception;


class MinimumSubtotalRequired extends PromoCodeException
{
    public function __construct($message = "Subtotal minimum not met.", $code = 0, PromoCodeException $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}