<?php

namespace Bundle\PublicSiteBundle\Component\Cart\Exception;


use Exception;

class InvalidCartException extends Exception
{

    /**
     * InvalidCartException constructor.
     * @param string $message
     * @param int $code
     * @param Exception $previous
     */
    public function __construct($message = "Invalid cart", $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}