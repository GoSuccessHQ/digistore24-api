<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Tests\Unit\Response\ConversionTool;

use GoSuccess\Digistore24\Api\Http\Response;
use GoSuccess\Digistore24\Api\Response\ConversionTool\ListConversionToolsResponse;
use PHPUnit\Framework\TestCase;

final class ListConversionToolsResponseTest extends TestCase
{
    public function test_can_create_from_array(): void
    {
        $data = [
            'smartupgrades' => [
                [
                    'id' => 1,
                    'name' => 'Upgrade auf Komplettversion',
                    'authkey' => 'R7w4XmVXgIkZ2iGceLhc2AXBh',
                    'created_at' => '2016-03-17 15:40:50',
                    'is_custom_css_used' => 'N',
                    'custom_css' => null,
                    'upgrade_to_product_id' => 12345,
                    'product_ids' => '373,20,340',
                ],
                ['id' => 2, 'name' => 'Upgrade 2'],
            ],
        ];
        $response = ListConversionToolsResponse::fromArray($data);

        $this->assertInstanceOf(ListConversionToolsResponse::class, $response);
        $this->assertCount(2, $response->smartupgrades);

        $first = $response->smartupgrades[0];
        $this->assertSame(1, $first->id);
        $this->assertSame('Upgrade auf Komplettversion', $first->name);
        $this->assertSame('R7w4XmVXgIkZ2iGceLhc2AXBh', $first->authkey);
        $this->assertInstanceOf(\DateTimeImmutable::class, $first->createdAt);
        $this->assertFalse($first->isCustomCssUsed);
        $this->assertNull($first->customCss);
        $this->assertSame(12345, $first->upgradeToProductId);
        $this->assertSame('373,20,340', $first->productIds);

        $this->assertArrayHasKey('smartupgrades', $response->data);
    }

    public function test_can_create_from_response(): void
    {
        $httpResponse = new Response(
            statusCode: 200,
            data: [
                'smartupgrades' => [
                    ['id' => 1, 'name' => 'Upgrade 1'],
                ],
            ],
            headers: [],
            rawBody: '',
        );

        $response = ListConversionToolsResponse::fromResponse($httpResponse);

        $this->assertInstanceOf(ListConversionToolsResponse::class, $response);
        $this->assertCount(1, $response->smartupgrades);
        $this->assertSame(1, $response->smartupgrades[0]->id);
    }

    public function test_has_raw_response(): void
    {
        $httpResponse = new Response(
            statusCode: 200,
            data: [],
            headers: [],
            rawBody: 'test',
        );

        $response = ListConversionToolsResponse::fromResponse($httpResponse);

        $this->assertInstanceOf(Response::class, $response->rawResponse);
    }
}
