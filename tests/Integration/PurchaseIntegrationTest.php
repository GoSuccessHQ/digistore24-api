<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Tests\Integration;

use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Request\Purchase\GetPurchaseRequest;
use GoSuccess\Digistore24\Api\Request\Purchase\ListPurchasesRequest;
use GoSuccess\Digistore24\Api\Response\Purchase\GetPurchaseResponse;
use GoSuccess\Digistore24\Api\Response\Purchase\ListPurchasesResponse;
use PHPUnit\Framework\Attributes\Group;

#[Group('integration')]
#[Group('purchase')]
final class PurchaseIntegrationTest extends IntegrationTestCase
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
     * Test getting a specific purchase
     */
    public function testGetPurchase(): void
    {
        $purchaseId = $this->requireConfig(
            'DS24_TEST_PURCHASE_ID',
            'Test purchase ID required for purchase tests',
        );

        $request = new GetPurchaseRequest(purchaseId: $purchaseId);
        $response = $this->client->purchases->get($request);

        $this->assertInstanceOf(GetPurchaseResponse::class, $response);
        $this->assertNotEmpty($response->purchaseId);

        // Product details now live on the typed line items.
        $this->assertNotEmpty($response->items);
        $this->assertNotNull($response->items[0]->productId);

        // Buyer details now live on the typed buyer object.
        $this->assertNotNull($response->buyer);
        $this->assertNotEmpty($response->buyer->email);
    }

    /**
     * Test listing purchases
     */
    public function testListPurchases(): void
    {
        $response = $this->client->purchases->list(new ListPurchasesRequest());

        $this->assertInstanceOf(ListPurchasesResponse::class, $response);
    }
}
