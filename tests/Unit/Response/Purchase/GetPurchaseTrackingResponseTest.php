<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Tests\Unit\Response\Purchase;

use GoSuccess\Digistore24\Api\DTO\PurchaseTrackingInfoData;
use GoSuccess\Digistore24\Api\Http\Response;
use GoSuccess\Digistore24\Api\Response\Purchase\GetPurchaseTrackingResponse;
use PHPUnit\Framework\TestCase;

final class GetPurchaseTrackingResponseTest extends TestCase
{
    public function test_can_create_from_array(): void
    {
        $data = [
            'data' => [
                'utm_params' => [
                    'utm_source' => 'google',
                    'utm_medium' => 'cpc',
                    'utm_campaign' => 'summer_sale',
                    'utm_term' => 'online course',
                    'utm_content' => 'banner_a',
                ],
                'click_id' => 'CLICK123',
                'sub_ids' => ['sid_a', 'sid_b'],
                'vendor_key' => 'VKEY99',
                'campaign_key' => 'CKEY42',
            ],
        ];
        $response = GetPurchaseTrackingResponse::fromArray($data);

        $this->assertInstanceOf(GetPurchaseTrackingResponse::class, $response);
        $this->assertInstanceOf(PurchaseTrackingInfoData::class, $response->tracking);
        $this->assertSame('CLICK123', $response->tracking->clickId);
        $this->assertSame('VKEY99', $response->tracking->vendorKey);
        $this->assertSame('CKEY42', $response->tracking->campaignKey);
        $this->assertSame(['sid_a', 'sid_b'], $response->tracking->subIds);
        $this->assertNotNull($response->tracking->utmParams);
        $this->assertSame('google', $response->tracking->utmParams->utmSource);
        $this->assertSame('cpc', $response->tracking->utmParams->utmMedium);

        // Raw payload still available.
        $this->assertSame('CLICK123', $response->data['click_id']);
    }

    public function test_can_create_from_response(): void
    {
        $httpResponse = new Response(
            statusCode: 200,
            data: [
                'data' => [
                    'data' => [
                        'click_id' => 'CLICK999',
                        'campaign_key' => 'winter_promo',
                    ],
                ],
            ],
            headers: [],
            rawBody: '',
        );

        $response = GetPurchaseTrackingResponse::fromResponse($httpResponse);

        $this->assertInstanceOf(GetPurchaseTrackingResponse::class, $response);
        $this->assertNotNull($response->tracking);
        $this->assertSame('CLICK999', $response->tracking->clickId);
        $this->assertSame('winter_promo', $response->tracking->campaignKey);
    }

    public function test_can_parse_map_of_purchases(): void
    {
        $data = [
            'data' => [
                'P111' => [
                    'click_id' => 'C1',
                    'vendor_key' => 'V1',
                ],
                'P222' => [
                    'click_id' => 'C2',
                    'vendor_key' => 'V2',
                ],
            ],
        ];
        $response = GetPurchaseTrackingResponse::fromArray($data);

        $this->assertCount(2, $response->trackingByPurchase);
        $this->assertSame('C1', $response->trackingByPurchase['P111']->clickId);
        $this->assertSame('C2', $response->trackingByPurchase['P222']->clickId);
        // Convenience accessor exposes the first entry.
        $this->assertNotNull($response->tracking);
        $this->assertSame('C1', $response->tracking->clickId);
    }

    public function test_has_raw_response(): void
    {
        $httpResponse = new Response(
            statusCode: 200,
            data: [
                'data' => [
                    'click_id' => 'CLICK111',
                ],
            ],
            headers: [],
            rawBody: 'test',
        );

        $response = GetPurchaseTrackingResponse::fromResponse($httpResponse);

        $this->assertInstanceOf(Response::class, $response->rawResponse);
    }
}
