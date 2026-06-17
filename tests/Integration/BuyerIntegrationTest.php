<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Tests\Integration;

use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\DTO\BuyerData;
use GoSuccess\Digistore24\Api\Request\Buyer\GetBuyerRequest;
use GoSuccess\Digistore24\Api\Request\Buyer\ListBuyersRequest;
use GoSuccess\Digistore24\Api\Response\Buyer\GetBuyerResponse;
use GoSuccess\Digistore24\Api\Response\Buyer\ListBuyersResponse;
use PHPUnit\Framework\Attributes\Group;

#[Group('integration')]
#[Group('buyer')]
final class BuyerIntegrationTest extends IntegrationTestCase
{
    private Digistore24 $client;

    protected function setUp(): void
    {
        parent::setUp();

        $apiKey = $this->getApiKey();
        $config = new Configuration(apiKey: $apiKey);
        $this->client = new Digistore24($config);
    }

    /**
     * Test getting a buyer by email
     */
    public function testGetBuyerByEmail(): void
    {
        $buyerEmail = $this->requireConfig(
            'DS24_TEST_BUYER_EMAIL',
            'Test buyer email required for buyer tests',
        );

        $request = new GetBuyerRequest(buyerId: $buyerEmail);
        $response = $this->client->buyers->get($request);

        $this->assertInstanceOf(GetBuyerResponse::class, $response);
        $this->assertInstanceOf(BuyerData::class, $response->buyer);
        $this->assertNotEmpty($response->buyer->email);
    }

    /**
     * Test listing buyers
     */
    public function testListBuyers(): void
    {
        $response = $this->client->buyers->list(new ListBuyersRequest());

        $this->assertInstanceOf(ListBuyersResponse::class, $response);
        $this->assertGreaterThanOrEqual(0, $response->itemCount);

        // If we have buyers, validate structure
        if (count($response->items) > 0) {
            $this->assertInstanceOf(\GoSuccess\Digistore24\Api\DTO\BuyerData::class, $response->items[0]);
        }
    }
}
