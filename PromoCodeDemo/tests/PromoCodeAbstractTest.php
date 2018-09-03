<?php
namespace Bundle\PublicSiteBundle\Tests\unit\PromoCode;

use Bundle\PublicSiteBundle\Component\Cart\TotalsGenerator\PromoCode\PromoCodeAbstract;
use Bundle\SchemaBundle\Entity\PromoCode;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PromoCodeAbstractTest extends WebTestCase
{
    private function getEntityManagerMock()
    {
        $entityManagerMock = $this->getMockBuilder('\Doctrine\ORM\EntityManager')->disableOriginalConstructor()->getMock();

        return $entityManagerMock;
    }


    public function testFutureDatesValid()
    {
        $array = [
            'rules' => [
                'type' => 'hasAnyItem',
                'valid_at' => '2020-04-01',
                'valid_until' => '2020-04-31',
                'system' => 'conference',
                'catalog_item_id' => null,
            ],
            'action' => [
                'type' => 'PercentageOfCart',
                'discount_catalog_item_id' => 90,
                'subtotal_min' => 0.01,
                'amount' => .02,
            ]
        ];
        $promoCode = new PromoCode();
        $promoCode->setConfig(json_encode($array));
        $em = $this->getEntityManagerMock();

        $service = new class($em, $promoCode) extends PromoCodeAbstract{
            public function apply($normalizedLines){}
        };

        $isInTheFuture = $service->promoCodeIsInTheFuture();
        $isExpired = $service->promoCodeIsExpired();

        $this->assertTrue($isInTheFuture);
        $this->assertFalse($isExpired);
    }

    public function testPastDatesValid()
    {
        $array = [
            'rules' => [
                'type' => 'hasAnyItem',
                'valid_at' => '2000-04-01',
                'valid_until' => '2000-04-31',
                'system' => 'conference',
                'catalog_item_id' => null,
            ],
            'action' => [
                'type' => 'PercentageOfCart',
                'discount_catalog_item_id' => 90,
                'subtotal_min' => 0.01,
                'amount' => .02,
            ]
        ];
        $promoCode = new PromoCode();
        $promoCode->setConfig(json_encode($array));
        $em = $this->getEntityManagerMock();

        $service = new class($em, $promoCode) extends PromoCodeAbstract{
            public function apply($normalizedLines){}
        };

        $isInTheFuture = $service->promoCodeIsInTheFuture();
        $isExpired = $service->promoCodeIsExpired();

        $this->assertFalse($isInTheFuture);
        $this->assertTrue($isExpired);
    }

    public function testLinesHaveMinimumSubtotal()
    {
        $file = file_get_contents('../Data/promocode_test_1.json');
        $data = json_decode($file, true);

        $array = [
            'rules' => [
                'type' => 'hasAnyItem',
                'valid_at' => '2018-04-01',
                'valid_until' => '2030-04-31',
                'system' => 'conference',
                'catalog_item_id' => null,
            ],
            'action' => [
                'type' => 'PercentageOfCart',
                'discount_catalog_item_id' => 90,
                'subtotal_min' => 0.01,
                'amount' => .02,
            ]
        ];
        $promoCode = new PromoCode();
        $promoCode->setConfig(json_encode($array));
        $em = $this->getEntityManagerMock();

        $service = new class($em, $promoCode) extends PromoCodeAbstract{
            public function apply($normalizedLines){}
        };

        $result = $service->linesHaveMinimumSubtotal();

        $this->assertTrue($result);
    }
}