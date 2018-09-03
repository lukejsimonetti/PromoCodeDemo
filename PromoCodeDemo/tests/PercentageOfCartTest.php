<?php
namespace Bundle\PublicSiteBundle\Tests\unit\PromoCode;

use Bundle\PublicSiteBundle\Component\Cart\TotalsGenerator\PromoCode\PercentageOfCart;
use Bundle\SchemaBundle\Entity\PromoCode;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
require('/var/www/project/sites/www/app/AppKernel.php');

class PercentageOfCartTest extends WebTestCase
{

    private function getEntityManagerMock()
    {
        $entityManagerMock = $this->getMockBuilder('\Doctrine\ORM\EntityManager')->disableOriginalConstructor()->getMock();

        return $entityManagerMock;
    }

    public function testApply()
    {
        $file = file_get_contents('../Data/promocode_test_1.json');
        $normalizedLines = json_decode($file, true);

        $array = [
            'rules' => [
                'type' => 'hasAnyItem',
                'system' => 'conference',
                'catalog_item_id' => null,
            ],
            'action' => [
                'type' => 'PercentageOfCart',
                'discount_catalog_item_id' => 90,
                'subtotal_min' => 0.01,
                'amount' => .02,
                'percentage' => 15
            ]
        ];
        $promoCode = new PromoCode();
        $promoCode->setStartAt(new DateTime('2018-04-01'));
        $promoCode->setEndAt(new DateTime('2030-04-31'));
        $promoCode->setConfig(json_encode($array));

        $service = $this->getMockBuilder('Bundle\PublicSiteBundle\Component\Cart\TotalsGenerator\PromoCode\PercentageOfCart')
            ->setMethods(['__constructor', 'getDiscountLine'])
            ->setConstructorArgs([$this->getEntityManagerMock(), $promoCode])
            ->getMock();

        $service->expects($this->any())
            ->method('getDiscountLine')
            ->willReturn(
                [
                    'catalog_item_id' => 90,
                    'is_discount_line' => true,
                    'item_code' => 'PERCENTAGEOFCART',
                    'description' => 'description',
                    'quantity' => 1,
                    'price' => -(1 * $array['action']['amount']),
                    'discount_uid' => '34sx3d'
                ]
            );
        $lines = $service->apply($normalizedLines);

        $lineCount = 0;
        $hasDiscountLine = false;

        foreach($lines as $line){
            $lineCount++;

            if($line['catalog_item_id'] == $array['action']['discount_catalog_item_id']){
                $hasDiscountLine = true;
            }
        }

        $this->assertTrue($hasDiscountLine);
        $this->assertEquals(4, $lineCount);
    }

    public function testLinesHaveMinimumSubtotal()
    {
        $file = file_get_contents('../Data/promocode_test_1.json');
        $normalizedLines = json_decode($file, true);

        $array = [
            'rules' => [
                'type' => 'hasAnyItem',
                'system' => 'conference',
                'catalog_item_id' => null,
            ],
            'action' => [
                'type' => 'percentDiscountOnCart',
                'discount_catalog_item_id' => 90,
                'subtotal_min' => 0.01,
                'amount' => .02,
                'percentage' => 15
            ]
        ];
        $promoCode = new PromoCode();
        $promoCode->setStartAt(new DateTime('2018-04-01'));
        $promoCode->setEndAt(new DateTime('2030-04-31'));
        $promoCode->setConfig(json_encode($array));

        $service = $this->getMockBuilder('Bundle\PublicSiteBundle\Component\Cart\TotalsGenerator\PromoCode\PercentageOfCart')
            ->setMethods(['__constructor'])
            ->setConstructorArgs([$this->getEntityManagerMock(), $promoCode])
            ->getMock();

        $service->calculateCartSubtotal($normalizedLines);
        $result = $service->linesHaveMinimumSubtotal();

        $this->assertTrue($result);
    }

    public function testGetPercentageOfCart()
    {
        $file = file_get_contents('../Data/promocode_test_1.json');
        $normalizedLines = json_decode($file, true);

        $array = [
            'rules' => [
                'type' => 'hasAnyItem',
                'system' => 'conference',
                'catalog_item_id' => null,
            ],
            'action' => [
                'type' => 'percentDiscountOnCart',
                'discount_catalog_item_id' => 90,
                'subtotal_min' => 0.01,
                'amount' => .02,
                'percentage' => 15,
            ]
        ];
        $promoCode = new PromoCode();
        $promoCode->setStartAt(new DateTime('2018-04-01'));
        $promoCode->setEndAt(new DateTime('2030-04-31'));
        $promoCode->setConfig(json_encode($array));

        $service = $this->getMockBuilder('Bundle\PublicSiteBundle\Component\Cart\TotalsGenerator\PromoCode\PercentageOfCart')
            ->setMethods(['__constructor'])
            ->setConstructorArgs([$this->getEntityManagerMock(), $promoCode])
            ->getMock();

        $service->calculateCartSubtotal($normalizedLines);
        $result = $service->getPercentageOfCart();

        $this->assertEquals(49.05, $result);

    }

}