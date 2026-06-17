<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Tests\Unit\Response\SmartUpgrade;

use GoSuccess\Digistore24\Api\DTO\SmartUpgradeData;
use GoSuccess\Digistore24\Api\Http\Response;
use GoSuccess\Digistore24\Api\Response\SmartUpgrade\ListSmartUpgradesResponse;
use PHPUnit\Framework\TestCase;

final class ListSmartUpgradesResponseTest extends TestCase
{
    public function test_can_create_from_array(): void
    {
        $data = [
            'data' => [
                'smartupgrades' => [
                    [
                        'id' => 1001,
                        'name' => 'Starter to Pro',
                        'authkey' => 'auth-abc-123',
                        'created_at' => '2026-01-15 10:30:00',
                        'is_custom_css_used' => 'Y',
                        'custom_css' => '.widget { color: red; }',
                        'upgrade_to_product_id' => 200,
                        'product_ids' => '100,101,102',
                    ],
                    [
                        'id' => 1002,
                        'name' => 'Pro to Premium',
                        'authkey' => 'auth-def-456',
                        'created_at' => '2026-02-20 08:15:00',
                        'is_custom_css_used' => 'N',
                        'custom_css' => null,
                        'upgrade_to_product_id' => 300,
                        'product_ids' => '200',
                    ],
                ],
            ],
        ];
        $response = ListSmartUpgradesResponse::fromArray($data);

        $this->assertInstanceOf(ListSmartUpgradesResponse::class, $response);

        $smartupgrades = $response->smartupgrades;
        $this->assertCount(2, $smartupgrades);

        $first = $smartupgrades[0];
        $this->assertInstanceOf(SmartUpgradeData::class, $first);
        $this->assertSame(1001, $first->id);
        $this->assertSame('Starter to Pro', $first->name);
        $this->assertSame('auth-abc-123', $first->authkey);
        $this->assertSame('2026-01-15 10:30:00', $first->createdAt?->format('Y-m-d H:i:s'));
        $this->assertTrue($first->isCustomCssUsed);
        $this->assertSame('.widget { color: red; }', $first->customCss);
        $this->assertSame(200, $first->upgradeToProductId);
        $this->assertSame('100,101,102', $first->productIds);

        $second = $smartupgrades[1];
        $this->assertInstanceOf(SmartUpgradeData::class, $second);
        $this->assertSame(1002, $second->id);
        $this->assertFalse($second->isCustomCssUsed);
        $this->assertNull($second->customCss);
        $this->assertSame('200', $second->productIds);

        $this->assertArrayHasKey('smartupgrades', $response->data);
    }

    public function test_can_create_from_response(): void
    {
        $httpResponse = new Response(
            statusCode: 200,
            data: [
                'result' => 'success',
                'data' => [
                    'smartupgrades' => [
                        [
                            'id' => 999,
                            'name' => 'Single Upgrade',
                            'authkey' => 'auth-999',
                            'created_at' => '2026-03-01 12:00:00',
                            'is_custom_css_used' => 'N',
                            'custom_css' => null,
                            'upgrade_to_product_id' => 500,
                            'product_ids' => '400',
                        ],
                    ],
                ],
            ],
            headers: [],
            rawBody: '',
        );

        $response = ListSmartUpgradesResponse::fromResponse($httpResponse);

        $this->assertInstanceOf(ListSmartUpgradesResponse::class, $response);
        $this->assertSame('success', $response->result);
        $this->assertCount(1, $response->smartupgrades);
        $this->assertInstanceOf(SmartUpgradeData::class, $response->smartupgrades[0]);
        $this->assertSame(999, $response->smartupgrades[0]->id);
        $this->assertFalse($response->smartupgrades[0]->isCustomCssUsed);
    }

    public function test_has_raw_response(): void
    {
        $httpResponse = new Response(
            statusCode: 200,
            data: ['data' => ['smartupgrades' => []]],
            headers: [],
            rawBody: 'test',
        );

        $response = ListSmartUpgradesResponse::fromResponse($httpResponse);

        $this->assertInstanceOf(Response::class, $response->rawResponse);
        $this->assertEmpty($response->smartupgrades);
    }
}
