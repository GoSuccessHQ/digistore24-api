<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Tests\Integration;

use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\DTO\BuyerData;
use GoSuccess\Digistore24\Api\Request\BuyUrl\CreateBuyUrlRequest;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

/**
 * Integration Test for Digistore24 Main Facade
 */
#[CoversClass(Digistore24::class)]
final class Digistore24Test extends TestCase
{
    private Digistore24 $client;

    protected function setUp(): void
    {
        // Use test API key for integration tests
        $config = new Configuration(apiKey: 'TEST-API-KEY-123456789');
        $config->timeout = 5;
        $config->maxRetries = 0; // Disable retries for faster tests

        $this->client = new Digistore24($config);
    }

    public function testClientHasAllResources(): void
    {
        $this->assertInstanceOf(\GoSuccess\Digistore24\Api\Resource\AffiliateResource::class, $this->client->affiliates);
        $this->assertInstanceOf(\GoSuccess\Digistore24\Api\Resource\BillingResource::class, $this->client->billing);
        $this->assertInstanceOf(\GoSuccess\Digistore24\Api\Resource\BuyerResource::class, $this->client->buyers);
        $this->assertInstanceOf(\GoSuccess\Digistore24\Api\Resource\BuyUrlResource::class, $this->client->buyUrls);
        $this->assertInstanceOf(\GoSuccess\Digistore24\Api\Resource\CountryResource::class, $this->client->countries);
        $this->assertInstanceOf(\GoSuccess\Digistore24\Api\Resource\IpnResource::class, $this->client->ipn);
        $this->assertInstanceOf(\GoSuccess\Digistore24\Api\Resource\MonitoringResource::class, $this->client->monitoring);
        $this->assertInstanceOf(\GoSuccess\Digistore24\Api\Resource\ProductResource::class, $this->client->products);
        $this->assertInstanceOf(\GoSuccess\Digistore24\Api\Resource\PurchaseResource::class, $this->client->purchases);
        $this->assertInstanceOf(\GoSuccess\Digistore24\Api\Resource\RebillingResource::class, $this->client->rebilling);
        $this->assertInstanceOf(\GoSuccess\Digistore24\Api\Resource\UserResource::class, $this->client->users);
        $this->assertInstanceOf(\GoSuccess\Digistore24\Api\Resource\VoucherResource::class, $this->client->vouchers);
    }

    public function testCanCreateRequestWithPropertyHooks(): void
    {
        $request = new CreateBuyUrlRequest();
        $request->productId = 12345;
        $request->validUntil = '48h';

        $this->assertSame(12345, $request->productId);
        $this->assertSame('48h', $request->validUntil);
    }

    public function testCanCreateBuyerDataWithValidation(): void
    {
        $buyer = BuyerData::fromArray([
            'email' => 'test@example.com',
            'first_name' => 'John',
            'last_name' => 'Doe',
            'country' => 'DE',
        ]);

        $this->assertSame('test@example.com', $buyer->email);
        $this->assertSame('John', $buyer->firstName);
        $this->assertSame('Doe', $buyer->lastName);
        $this->assertSame('DE', $buyer->country);
    }

    public function testPropertyHookValidationThrowsExceptionForInvalidEmail(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid email');

        // Validation runs on direct assignment (user input); fromArray() trusts
        // inbound API data and intentionally bypasses the validating set hooks.
        $buyer = new BuyerData();
        $buyer->email = 'invalid-email';
    }

    public function testPropertyHookValidationThrowsExceptionForEmptyProductId(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Product ID is required');

        $request = new CreateBuyUrlRequest();
        $request->productId = '';
    }

    public function testClientPropertyReturnsApiClient(): void
    {
        $client = $this->client->client;
        $this->assertInstanceOf(\GoSuccess\Digistore24\Api\Client\ApiClient::class, $client);
    }
}
