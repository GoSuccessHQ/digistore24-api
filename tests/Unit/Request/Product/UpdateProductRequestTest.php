<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Tests\Unit\Request\Product;

use GoSuccess\Digistore24\Api\Enum\HttpMethod;
use GoSuccess\Digistore24\Api\Enum\ProductApprovalStatus;
use GoSuccess\Digistore24\Api\Enum\ProductBuyerType;
use GoSuccess\Digistore24\Api\Request\Product\UpdateProductRequest;
use PHPUnit\Framework\TestCase;

final class UpdateProductRequestTest extends TestCase
{
    public function test_can_create_instance(): void
    {
        $request = new UpdateProductRequest(productId: 12345);

        $this->assertInstanceOf(UpdateProductRequest::class, $request);
    }

    public function test_endpoint_and_method(): void
    {
        $request = new UpdateProductRequest(productId: 12345);

        $this->assertSame('/updateProduct', $request->getEndpoint());
        $this->assertSame(HttpMethod::PUT, $request->getMethod());
    }

    public function test_to_array_includes_product_id_and_optional_fields(): void
    {
        $request = new UpdateProductRequest(
            productId: 12345,
            nameDe: 'Aktualisiertes Produkt',
            nameEn: 'Updated Product',
        );

        $array = $request->toArray();
        $this->assertSame(12345, $array['product_id']);
        $this->assertSame('Aktualisiertes Produkt', $array['name_de']);
    }

    public function test_to_array_emits_enum_values(): void
    {
        $request = new UpdateProductRequest(
            productId: 12345,
            approvalStatus: ProductApprovalStatus::PENDING,
            buyerType: ProductBuyerType::BUSINESS,
        );

        $array = $request->toArray();
        $this->assertSame('pending', $array['approval_status']);
        $this->assertSame('business', $array['buyer_type']);
    }

    public function test_to_array_includes_currency_and_access_instructions(): void
    {
        $request = new UpdateProductRequest(
            productId: 12345,
            currency: 'USD,EUR',
            accessInstructionsDe: 'Zugang unter example.com',
        );

        $array = $request->toArray();
        $this->assertSame('USD,EUR', $array['currency']);
        $this->assertSame('Zugang unter example.com', $array['access_instructions_de']);
    }

    public function test_validate_returns_empty_array(): void
    {
        $request = new UpdateProductRequest(productId: 12345);

        $errors = $request->validate();
        $this->assertEmpty($errors);
    }
}
