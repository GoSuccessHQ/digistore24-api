<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Tests\Unit\Request\Buyer;

use GoSuccess\Digistore24\Api\Enum\HttpMethod;
use GoSuccess\Digistore24\Api\Enum\Salutation;
use GoSuccess\Digistore24\Api\Request\Buyer\UpdateBuyerRequest;
use PHPUnit\Framework\TestCase;

final class UpdateBuyerRequestTest extends TestCase
{
    public function test_can_create_instance(): void
    {
        $request = new UpdateBuyerRequest(buyerId: 'B12345');

        $this->assertInstanceOf(UpdateBuyerRequest::class, $request);
    }

    public function test_endpoint_returns_correct_value(): void
    {
        $request = new UpdateBuyerRequest(buyerId: 'B12345');

        $this->assertSame('/updateBuyer', $request->getEndpoint());
    }

    public function test_method_is_put(): void
    {
        $request = new UpdateBuyerRequest(buyerId: 'B12345');

        $this->assertSame(HttpMethod::PUT, $request->getMethod());
    }

    public function test_to_array_includes_buyer_id_only(): void
    {
        $request = new UpdateBuyerRequest(buyerId: 'B12345');

        $array = $request->toArray();
        $this->assertSame('B12345', $array['buyer_id']);
        $this->assertCount(1, $array);
    }

    public function test_to_array_sends_flat_address_fields(): void
    {
        $request = new UpdateBuyerRequest(
            buyerId: 'B12345',
            email: 'updated@example.com',
            firstName: 'John',
            lastName: 'Doe',
            salutation: Salutation::MR,
            title: 'Dr.',
            company: 'ACME',
            streetName: 'Main St',
            streetNumber: '42',
            phoneNumber: '+49123456',
            city: 'Berlin',
            zipcode: '10115',
            state: 'BE',
            country: 'DE',
        );

        $array = $request->toArray();

        $this->assertSame('B12345', $array['buyer_id']);
        $this->assertSame('updated@example.com', $array['email']);
        $this->assertSame('John', $array['first_name']);
        $this->assertSame('Doe', $array['last_name']);
        $this->assertSame('M', $array['salutation']);
        $this->assertSame('Dr.', $array['title']);
        $this->assertSame('ACME', $array['company']);
        $this->assertSame('Main St', $array['street_name']);
        $this->assertSame('42', $array['street_number']);
        $this->assertSame('+49123456', $array['phone_number']);
        $this->assertSame('Berlin', $array['city']);
        $this->assertSame('10115', $array['zipcode']);
        $this->assertSame('BE', $array['state']);
        $this->assertSame('DE', $array['country']);
        $this->assertArrayNotHasKey('address', $array);
    }

    public function test_validate_returns_empty_array(): void
    {
        $request = new UpdateBuyerRequest(buyerId: 'B12345');

        $errors = $request->validate();
        $this->assertEmpty($errors);
    }
}
