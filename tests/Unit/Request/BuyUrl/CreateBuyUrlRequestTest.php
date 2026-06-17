<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Tests\Unit\Request\BuyUrl;

use GoSuccess\Digistore24\Api\DTO\BuyerData;
use GoSuccess\Digistore24\Api\DTO\BuyUrlAddonData;
use GoSuccess\Digistore24\Api\DTO\TrackingData;
use GoSuccess\Digistore24\Api\Enum\AffiliatePriority;
use GoSuccess\Digistore24\Api\Request\BuyUrl\CreateBuyUrlRequest;
use PHPUnit\Framework\TestCase;

final class CreateBuyUrlRequestTest extends TestCase
{
    public function test_can_create_instance(): void
    {
        $request = new CreateBuyUrlRequest();
        $request->productId = 12345;

        $this->assertInstanceOf(CreateBuyUrlRequest::class, $request);
    }

    public function test_endpoint_returns_correct_value(): void
    {
        $request = new CreateBuyUrlRequest();
        $request->productId = 12345;

        $this->assertSame('/createBuyUrl', $request->getEndpoint());
    }

    public function test_to_array_includes_product_id(): void
    {
        $request = new CreateBuyUrlRequest();
        $request->productId = 12345;

        $array = $request->toArray();
        $this->assertSame(12345, $array['product_id']);
    }

    public function test_to_array_includes_optional_data(): void
    {
        $request = new CreateBuyUrlRequest();
        $request->productId = 12345;
        $request->validUntil = '48h';
        $request->placeholders = ['title' => 'Custom Title'];

        $array = $request->toArray();
        $this->assertSame('48h', $array['valid_until']);
        $this->assertArrayHasKey('placeholders', $array);
    }

    public function test_validate_fails_without_product_id(): void
    {
        $request = new CreateBuyUrlRequest();

        $errors = $request->validate();
        $this->assertNotEmpty($errors);
    }

    public function test_validate_succeeds_with_product_id(): void
    {
        $request = new CreateBuyUrlRequest();
        $request->productId = 12345;

        $errors = $request->validate();
        $this->assertEmpty($errors);
    }

    public function test_to_array_serializes_nested_buyer_tracking_and_addons(): void
    {
        $request = new CreateBuyUrlRequest();
        $request->productId = 12345;

        $buyer = new BuyerData(email: 'buyer@example.com', firstName: 'John');
        $request->buyer = $buyer;

        $tracking = new TrackingData();
        $tracking->affiliate = 'partner123';
        $tracking->affiliatePriority = AffiliatePriority::AS_SET;
        $request->tracking = $tracking;

        $addon = new BuyUrlAddonData();
        $addon->productId = '67890';
        $addon->defaultQuantity = 2;
        $request->addons = [$addon];

        $array = $request->toArray();

        $this->assertSame(12345, $array['product_id']);
        $this->assertIsArray($array['buyer']);
        $this->assertSame('buyer@example.com', $array['buyer']['email']);
        $this->assertSame('John', $array['buyer']['first_name']);
        // Response-only buyer fields must never leak into the request
        $this->assertArrayNotHasKey('buyer_type', $array['buyer']);
        $this->assertArrayNotHasKey('address_id', $array['buyer']);

        $this->assertIsArray($array['tracking']);
        $this->assertSame('partner123', $array['tracking']['affiliate']);
        $this->assertSame('as_set', $array['tracking']['affiliate_priority']);

        $this->assertIsArray($array['addons']);
        $firstAddon = $array['addons'][0];
        $this->assertIsArray($firstAddon);
        $this->assertSame('67890', $firstAddon['product_id']);
        $this->assertSame(2, $firstAddon['default_quantity']);
    }
}
