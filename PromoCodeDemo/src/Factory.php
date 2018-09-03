<?php

namespace Bundle\PublicSiteBundle\Component\Cart\TotalsGenerator\PromoCode;

use Bundle\SchemaBundle\Entity\Cart;
use Bundle\SchemaBundle\Entity\PromoCode;
use Bundle\PublicSiteBundle\Component\Cart\TotalsGenerator\Normalizer\Factory as NormalizerFactory;
use Doctrine\ORM\EntityManagerInterface;
use Exception;

class Factory
{
    /** @var PromoCode */
    public $promoCode;

    /** @var EntityManager */
    public $em;

    /**
     * TotalsEngine constructor.
     * @param PromoCode $promoCode
     * @param EntityManagerInterface $em
     */
    public function __construct($em, $promoCode)
    {
        $this->em = $em;
        $this->promoCode = $promoCode;
    }

    /**
     * @param $normalizedLines
     * @return array
     */
    public function applyPromoCode($normalizedLines)
    {
        $class = $this->getPromoCodeClass();
        /** @var PromoCodeAbstract $instantiatedClass */
        $instantiatedClass = new $class($this->em, $this->promoCode);

        return $instantiatedClass->apply($normalizedLines);
    }

    /**
     * @param Cart $cart
     */
    public function runErrorFilter($cart)
    {
        $class = $this->getPromoCodeClass();

        $normalizer = new NormalizerFactory($this->em, $cart);
        $normalizedLines = $normalizer->normalizeCartItems();

        /** @var PromoCodeAbstract $instantiatedClass */
        $instantiatedClass = new $class($this->em, $this->promoCode);
        $instantiatedClass->runErrorFilter($normalizedLines);

        return;
    }

    /**
     * @return string
     * @throws Exception
     */
    public function getPromoCodeClass()
    {
        $config = json_decode($this->promoCode->getConfig(), true);

        $className = $config['action']['class'];
        $class = 'Bundle\PublicSiteBundle\Component\Cart\TotalsGenerator\PromoCode\\' . $className;

        if (!class_exists($class)){
            throw new Exception('The class: '.$class.' does not exist. ');
        }

        return $class;
    }
}