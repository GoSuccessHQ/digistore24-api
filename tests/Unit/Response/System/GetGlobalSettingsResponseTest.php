<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Tests\Unit\Response\System;

use GoSuccess\Digistore24\Api\DTO\ImageLimitsData;
use GoSuccess\Digistore24\Api\DTO\ImageMetaData;
use GoSuccess\Digistore24\Api\Http\Response;
use GoSuccess\Digistore24\Api\Response\System\GetGlobalSettingsResponse;
use PHPUnit\Framework\TestCase;

final class GetGlobalSettingsResponseTest extends TestCase
{
    /**
     * @return array<string, mixed>
     */
    private function sampleData(): array
    {
        return [
            'result' => 'success',
            'data' => [
                'image_metas' => [
                    'product' => [
                        'label' => 'Product image',
                        'limits' => [
                            'max_file_size_kb' => 2048,
                            'min_width' => 200,
                            'max_width' => 2000,
                            'min_height' => 200,
                            'max_height' => 2000,
                        ],
                        'limits_msg' => 'Max. 2048 KB, 200-2000 x 200-2000 px',
                    ],
                ],
                'types' => [
                    'first_billing_interval' => [
                        '4_day' => '4 Tage',
                        '1_month' => '1 Monat',
                    ],
                ],
            ],
        ];
    }

    public function test_can_create_from_array(): void
    {
        $response = GetGlobalSettingsResponse::fromArray(data: $this->sampleData());

        $this->assertInstanceOf(GetGlobalSettingsResponse::class, $response);
        $this->assertSame('success', $response->result);

        // image_metas dictionary -> typed DTOs
        $this->assertArrayHasKey('product', $response->imageMetas);
        $productMeta = $response->imageMetas['product'];
        $this->assertInstanceOf(ImageMetaData::class, $productMeta);
        $this->assertSame('Product image', $productMeta->label);
        $this->assertSame('Max. 2048 KB, 200-2000 x 200-2000 px', $productMeta->limitsMsg);

        $this->assertInstanceOf(ImageLimitsData::class, $productMeta->limits);
        $this->assertSame(2048, $productMeta->limits->maxFileSizeKb);
        $this->assertSame(200, $productMeta->limits->minWidth);
        $this->assertSame(2000, $productMeta->limits->maxWidth);
        $this->assertSame(200, $productMeta->limits->minHeight);
        $this->assertSame(2000, $productMeta->limits->maxHeight);

        // types dictionary-of-dictionaries
        $this->assertArrayHasKey('first_billing_interval', $response->types);
        $this->assertSame('4 Tage', $response->types['first_billing_interval']['4_day']);
        $this->assertSame('1 Monat', $response->types['first_billing_interval']['1_month']);

        // full inner payload retained
        $this->assertArrayHasKey('image_metas', $response->data);
        $this->assertArrayHasKey('types', $response->data);
    }

    public function test_can_create_from_response(): void
    {
        $httpResponse = new Response(
            statusCode: 200,
            data: $this->sampleData(),
            headers: ['Content-Type' => ['application/json']],
            rawBody: '{"result":"success"}',
        );

        $response = GetGlobalSettingsResponse::fromResponse(response: $httpResponse);

        $this->assertInstanceOf(GetGlobalSettingsResponse::class, $response);
        $this->assertSame('success', $response->result);
        $this->assertArrayHasKey('product', $response->imageMetas);
        $this->assertSame(2048, $response->imageMetas['product']->limits?->maxFileSizeKb);
        $this->assertSame('4 Tage', $response->types['first_billing_interval']['4_day']);
    }

    public function test_handles_empty_data(): void
    {
        $data = [
            'result' => 'success',
            'data' => [],
        ];

        $response = GetGlobalSettingsResponse::fromArray(data: $data);

        $this->assertInstanceOf(GetGlobalSettingsResponse::class, $response);
        $this->assertEmpty($response->imageMetas);
        $this->assertEmpty($response->types);
        $this->assertEmpty($response->data);
    }

    public function test_has_raw_response(): void
    {
        $httpResponse = new Response(
            statusCode: 200,
            data: [
                'result' => 'success',
                'data' => [
                    'image_metas' => [],
                    'types' => [],
                ],
            ],
            headers: ['Content-Type' => ['application/json']],
            rawBody: 'test body',
        );

        $response = GetGlobalSettingsResponse::fromResponse(response: $httpResponse);

        $this->assertInstanceOf(Response::class, $response->rawResponse);
        $this->assertSame(200, $response->rawResponse->statusCode);
        $this->assertSame('test body', $response->rawResponse->rawBody);
    }
}
