<?php

namespace Bundle\PublicSiteBundle\Component\Cart\Exception;

use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class PromoCodeException extends BadRequestHttpException
{
    public function __construct($message, $code = 0, BadRequestHttpException $previous = null)
    {
        parent::__construct($message, $previous);
    }

}