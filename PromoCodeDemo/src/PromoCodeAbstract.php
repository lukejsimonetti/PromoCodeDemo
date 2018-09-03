<?php

namespace Bundle\PublicSiteBundle\Component\Cart\TotalsGenerator\PromoCode;

use Bundle\SchemaBundle\Entity\CatalogItem;
use Bundle\SchemaBundle\Entity\PromoCode;
use DateTime;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityNotFoundException;
use Exception;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

abstract class PromoCodeAbstract
{
    /** @var EntityManager */
    public $em;

    /** @var PromoCode */
    public $promoCode;

    /** @var float */
    public $cartSubTotal = 0.00;

    /**
     * PromoCodeApplicator constructor.
     * @param EntityManager $em
     * @param PromoCode $promoCode
     */
    public function __construct(EntityManager $em, PromoCode $promoCode)
    {
        $this->em = $em;
        $this->promoCode = $promoCode;
    }

    abstract public function apply($normalizedLines);

    abstract public function runErrorFilter($normalizedLines);

    /**
     * @return string
     */
    public function generateUID()
    {
        return bin2hex(random_bytes(4));
    }

    /**
     * @return array
     */
    public function config()
    {
        return json_decode($this->promoCode->getConfig(), true);
    }

    /**
     * @param $normalizedLines
     * @return bool
     */
    public function hasCatalogItem($normalizedLines)
    {
        foreach ($normalizedLines as $line) {
            if ($line['catalog_item_id'] == $this->config()['rules']['catalog_item_id']) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return bool
     */
    public function promoCodeIsInTheFuture()
    {
        $startAt = $this->promoCode->getStartAt();
        $today = new DateTime();

        if ($today < $startAt) {
            return true;
        }

        return false;
    }

    /**
     * @return bool
     */
    public function promoCodeIsExpired()
    {
        $endAt = $this->promoCode->getEndAt();
        $today = new DateTime();

        if ($today > $endAt) {
            return true;
        }

        return false;
    }

    /**
     * @param $normalizedLines
     * @return bool
     */
    public function linesHaveAtLeastOneCorrectSystem($normalizedLines)
    {
        foreach ($normalizedLines as $line) {
            if ($this->config()['rules']['system'] == $line['system']) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return bool
     */
    public function linesHaveMinimumSubtotal()
    {
        if ($this->cartSubTotal > $this->config()['action']['subtotal_min']) {
            return true;
        }

        return false;
    }

    /**
     * @param $normalizedLines
     * @return void
     */
    public function calculateCartSubtotal($normalizedLines)
    {
        $this->cartSubTotal = 0.00;
        foreach ($normalizedLines as $line) {
            $this->cartSubTotal += $line['price'];
        }

        return;
    }

    /**
     * @param $normalizedLines
     * @param $qualifiedCatalogItemId
     * @param int $denominator
     * @return float
     */
    public function qualifyingItemsCount($normalizedLines, $qualifiedCatalogItemId, $denominator = 2)
    {
        $itemCount = 0;
        foreach ($normalizedLines as $line) {
            $isDiscountLine = $line['is_discount_line'] ?? false;
            $discountUID = $line['discount_uid'] ?? null;

            if (!$isDiscountLine && !$discountUID) {
                if ($qualifiedCatalogItemId == $line['catalog_item_id']) {
                    $itemCount++;
                }
            }
        }
        $paidItemsCount = floor($itemCount / $denominator);

        return $paidItemsCount;
    }

    /**
     * @param int $catalogItemId
     * @return
     * @throws EntityNotFoundException
     * @throws Exception
     */
    public function getCatalogItem($catalogItemId)
    {
        if (!$catalogItemId) {
            throw new Exception('No catalog item id was given.');
        }

        $catalogItem = $this->em->getReference('\Bundle\SchemaBundle\Entity\CatalogItem', $catalogItemId);

        if (!$catalogItem) {
            throw new EntityNotFoundException('No entity was found with id: ' . $catalogItemId);
        }

        return $catalogItem;
    }

    /**
     * @param integer $qty
     * @param $amount
     * @return array
     * @throws EntityNotFoundException
     * @throws Exception
     */
    public function getDiscountLine($qty, $amount)
    {
        /** @var CatalogItem $catalogItem */
        $catalogItem = $this->getCatalogItem($this->config()['action']['discount_catalog_item_id']);

        return [
            'catalog_item_id' => $catalogItem->getId(),
            'is_discount_line' => true,
            'item_code' => $catalogItem->getItemCode(),
            'description' => $catalogItem->getDescription(),
            'quantity' => $qty,
            'price' => -($qty * $amount),
            'discount_uid' => $this->generateUID(),
            'is_removable' => true
        ];
    }

    /**
     * @param $msg
     * @throws Exception
     */
    public function throwErrorMessage($msg)
    {
        throw new BadRequestHttpException($msg);
    }
}