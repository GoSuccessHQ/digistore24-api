<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Tests\Unit\Response\Purchase;

use GoSuccess\Digistore24\Api\DTO\CustomerToAffiliateDetailsData;
use GoSuccess\Digistore24\Api\Http\Response;
use GoSuccess\Digistore24\Api\Response\Purchase\GetCustomerToAffiliateBuyerDetailsResponse;
use PHPUnit\Framework\TestCase;

final class GetCustomerToAffiliateBuyerDetailsResponseTest extends TestCase
{
    public function test_can_create_from_array(): void
    {
        $data = [
            'data' => [
                'customer_affiliate_name' => 'buyer_aff',
                'customer_to_affiliate_url' => 'https://www.digistore24.com/c2a/register',
                'customer_affiliate_promo_url' => 'https://www.digistore24.com/c2a/promo',
            ],
        ];
        $response = GetCustomerToAffiliateBuyerDetailsResponse::fromArray($data);

        $this->assertInstanceOf(GetCustomerToAffiliateBuyerDetailsResponse::class, $response);
        $this->assertInstanceOf(CustomerToAffiliateDetailsData::class, $response->details);
        $this->assertSame('buyer_aff', $response->details->customerAffiliateName);
        $this->assertSame('https://www.digistore24.com/c2a/register', $response->details->customerToAffiliateUrl);
        $this->assertSame('https://www.digistore24.com/c2a/promo', $response->details->customerAffiliatePromoUrl);

        // Raw payload still available.
        $this->assertSame('buyer_aff', $response->data['customer_affiliate_name']);
    }

    public function test_can_create_from_response(): void
    {
        $httpResponse = new Response(
            statusCode: 200,
            data: [
                'data' => [
                    'data' => [
                        'customer_affiliate_name' => 'customer999',
                        'customer_to_affiliate_url' => 'https://www.digistore24.com/c2a/reg999',
                    ],
                ],
            ],
            headers: [],
            rawBody: '',
        );

        $response = GetCustomerToAffiliateBuyerDetailsResponse::fromResponse($httpResponse);

        $this->assertInstanceOf(GetCustomerToAffiliateBuyerDetailsResponse::class, $response);
        $this->assertNotNull($response->details);
        $this->assertSame('customer999', $response->details->customerAffiliateName);
    }

    public function test_can_parse_map_of_purchases(): void
    {
        $data = [
            'data' => [
                'P111' => [
                    'customer_affiliate_name' => 'aff_one',
                ],
                'P222' => [
                    'customer_affiliate_name' => 'aff_two',
                ],
            ],
        ];
        $response = GetCustomerToAffiliateBuyerDetailsResponse::fromArray($data);

        $this->assertCount(2, $response->detailsByPurchase);
        $this->assertSame('aff_one', $response->detailsByPurchase['P111']->customerAffiliateName);
        $this->assertSame('aff_two', $response->detailsByPurchase['P222']->customerAffiliateName);
        $this->assertNotNull($response->details);
        $this->assertSame('aff_one', $response->details->customerAffiliateName);
    }

    public function test_has_raw_response(): void
    {
        $httpResponse = new Response(
            statusCode: 200,
            data: [
                'data' => [
                    'data' => [
                        'customer_affiliate_name' => 'test_aff',
                    ],
                ],
            ],
            headers: [],
            rawBody: 'test',
        );

        $response = GetCustomerToAffiliateBuyerDetailsResponse::fromResponse($httpResponse);

        $this->assertInstanceOf(Response::class, $response->rawResponse);
    }
}
