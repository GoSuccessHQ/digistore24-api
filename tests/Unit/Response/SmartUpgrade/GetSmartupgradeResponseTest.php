<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Tests\Unit\Response\SmartUpgrade;

use GoSuccess\Digistore24\Api\Http\Response;
use GoSuccess\Digistore24\Api\Response\SmartUpgrade\GetSmartupgradeResponse;
use PHPUnit\Framework\TestCase;

final class GetSmartupgradeResponseTest extends TestCase
{
    public function test_can_create_from_array(): void
    {
        $data = [
            'result' => 'success',
            'data' => [
                'id' => 1001,
                'name' => 'Starter to Pro',
                'authkey' => 'auth-abc-123',
                'created_at' => '2026-01-15 10:30:00',
                'is_custom_css_used' => 'Y',
                'custom_css' => '.widget { color: red; }',
                'upgrade_to_product_id' => 200,
                'product_ids' => '100,101,102',
                'widget_html' => '<div class="su-widget">Upgrade now</div>',
            ],
        ];
        $response = GetSmartupgradeResponse::fromArray($data);

        $this->assertInstanceOf(GetSmartupgradeResponse::class, $response);
        $this->assertSame('success', $response->result);
        $this->assertSame(1001, $response->id);
        $this->assertSame('Starter to Pro', $response->name);
        $this->assertSame('auth-abc-123', $response->authkey);
        $this->assertSame('2026-01-15 10:30:00', $response->createdAt?->format('Y-m-d H:i:s'));
        $this->assertTrue($response->isCustomCssUsed);
        $this->assertSame('.widget { color: red; }', $response->customCss);
        $this->assertSame(200, $response->upgradeToProductId);
        $this->assertSame('100,101,102', $response->productIds);
        $this->assertSame('<div class="su-widget">Upgrade now</div>', $response->widgetHtml);

        // Full inner payload is preserved
        $this->assertSame(1001, $response->data['id']);
        $this->assertSame('Starter to Pro', $response->data['name']);
        $this->assertSame('<div class="su-widget">Upgrade now</div>', $response->data['widget_html']);
    }

    public function test_can_create_from_response(): void
    {
        $httpResponse = new Response(
            statusCode: 200,
            data: [
                'result' => 'success',
                'data' => [
                    'id' => 999,
                    'name' => 'Manual Upgrade',
                    'authkey' => 'auth-999',
                    'created_at' => '2026-03-01 12:00:00',
                    'is_custom_css_used' => 'N',
                    'custom_css' => null,
                    'upgrade_to_product_id' => 500,
                    'product_ids' => '400',
                ],
            ],
            headers: [],
            rawBody: '',
        );

        $response = GetSmartupgradeResponse::fromResponse($httpResponse);

        $this->assertInstanceOf(GetSmartupgradeResponse::class, $response);
        $this->assertSame('success', $response->result);
        $this->assertSame(999, $response->id);
        $this->assertSame('Manual Upgrade', $response->name);
        $this->assertFalse($response->isCustomCssUsed);
        $this->assertNull($response->customCss);
        $this->assertNull($response->widgetHtml);
        $this->assertSame('400', $response->productIds);
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

        $response = GetSmartupgradeResponse::fromResponse($httpResponse);

        $this->assertInstanceOf(Response::class, $response->rawResponse);
        $this->assertNull($response->id);
    }
}
