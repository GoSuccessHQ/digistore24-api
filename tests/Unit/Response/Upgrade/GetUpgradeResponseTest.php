<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Tests\Unit\Response\Upgrade;

use GoSuccess\Digistore24\Api\DTO\UpgradeCheckData;
use GoSuccess\Digistore24\Api\DTO\UpgradeItemData;
use GoSuccess\Digistore24\Api\Http\Response;
use GoSuccess\Digistore24\Api\Response\Upgrade\GetUpgradeResponse;
use PHPUnit\Framework\TestCase;

final class GetUpgradeResponseTest extends TestCase
{
    public function test_can_create_from_array(): void
    {
        $data = [
            'data' => [
                'item' => [
                    'id' => 123,
                    'name' => 'Upgrade to premium',
                    'upgrade_url' => 'https://www.digistore24.com/upgrade/ORDER_ID/abc',
                    'to_product_id' => 200,
                    'to_product_name' => 'Premium',
                    'is_active' => 'Y',
                    'authkey' => 'abc',
                    'fallback_product_id' => 50,
                    'buyer_readonly_keys' => 'none',
                    'upgrade_types' => ['100' => 'upgrade'],
                ],
                'check' => [
                    'is_upgrade_possible' => 'Y',
                    'is_one_click_payment_possible' => 'N',
                    'possible_upgrade_type' => 'upgrade',
                ],
            ],
        ];
        $response = GetUpgradeResponse::fromArray($data);

        $this->assertInstanceOf(GetUpgradeResponse::class, $response);
        $this->assertInstanceOf(UpgradeItemData::class, $response->item);
        $this->assertSame(123, $response->item->id);
        $this->assertSame('Upgrade to premium', $response->item->name);
        $this->assertSame(200, $response->item->toProductId);
        $this->assertTrue($response->item->isActive);
        $this->assertSame(['100' => 'upgrade'], $response->item->upgradeTypes);
        $this->assertInstanceOf(UpgradeCheckData::class, $response->check);
        $this->assertTrue($response->check->isUpgradePossible);
        $this->assertFalse($response->check->isOneClickPaymentPossible);
        $this->assertSame('upgrade', $response->check->possibleUpgradeType);
    }

    public function test_can_create_from_response(): void
    {
        $httpResponse = new Response(
            statusCode: 200,
            data: [
                'data' => [
                    'item' => [
                        'id' => 999,
                        'name' => 'Upgrade',
                    ],
                ],
            ],
            headers: [],
            rawBody: '',
        );

        $response = GetUpgradeResponse::fromResponse($httpResponse);

        $this->assertInstanceOf(GetUpgradeResponse::class, $response);
        $this->assertInstanceOf(UpgradeItemData::class, $response->item);
        $this->assertSame(999, $response->item->id);
        $this->assertNull($response->check);
    }

    public function test_has_raw_response(): void
    {
        $httpResponse = new Response(
            statusCode: 200,
            data: [
                'data' => [],
            ],
            headers: [],
            rawBody: 'test',
        );

        $response = GetUpgradeResponse::fromResponse($httpResponse);

        $this->assertInstanceOf(Response::class, $response->rawResponse);
    }
}
