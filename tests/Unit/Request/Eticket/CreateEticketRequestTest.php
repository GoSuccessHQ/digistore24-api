<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Tests\Unit\Request\Eticket;

use GoSuccess\Digistore24\Api\DTO\BuyerData;
use GoSuccess\Digistore24\Api\Enum\Salutation;
use GoSuccess\Digistore24\Api\Request\Eticket\CreateEticketRequest;
use PHPUnit\Framework\TestCase;

final class CreateEticketRequestTest extends TestCase
{
    private function makeBuyer(): BuyerData
    {
        $buyer = new BuyerData();
        $buyer->email = 'test@example.com';

        return $buyer;
    }

    public function test_can_create_instance(): void
    {
        $request = new CreateEticketRequest(
            buyer: $this->makeBuyer(),
            productId: 'P123',
            locationId: 'L456',
            templateId: 'T789',
            date: new \DateTime('2025-12-31'),
        );

        $this->assertInstanceOf(CreateEticketRequest::class, $request);
    }

    public function test_endpoint_returns_correct_value(): void
    {
        $request = new CreateEticketRequest(
            buyer: $this->makeBuyer(),
            productId: 'P123',
            locationId: 'L456',
            templateId: 'T789',
            date: new \DateTime('2025-12-31'),
        );

        $this->assertSame('/createEticket', $request->getEndpoint());
    }

    public function test_to_array_lowercases_salutation(): void
    {
        $buyer = $this->makeBuyer();
        $buyer->salutation = Salutation::MR;

        $request = new CreateEticketRequest(
            buyer: $buyer,
            productId: 'P123',
            locationId: 'L456',
            templateId: 'T789',
            date: new \DateTime('2025-12-31'),
        );

        $array = $request->toArray();
        $buyerData = $array['buyer'];
        $this->assertIsArray($buyerData);
        $this->assertSame('m', $buyerData['salutation']);
    }

    public function test_validate_returns_empty_array(): void
    {
        $request = new CreateEticketRequest(
            buyer: $this->makeBuyer(),
            productId: 'P123',
            locationId: 'L456',
            templateId: 'T789',
            date: new \DateTime('2025-12-31'),
        );

        $errors = $request->validate();
        $this->assertEmpty($errors);
    }
}
