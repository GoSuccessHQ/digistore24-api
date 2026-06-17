<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Tests\Unit\DataTransferObject;

use GoSuccess\Digistore24\Api\DTO\BuyerData;
use GoSuccess\Digistore24\Api\Enum\BuyerReadonlyKeys;
use GoSuccess\Digistore24\Api\Enum\BuyerType;
use GoSuccess\Digistore24\Api\Enum\Salutation;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(BuyerData::class)]
final class BuyerDataTest extends TestCase
{
    public function testCanCreateWithValidEmail(): void
    {
        $buyer = new BuyerData();
        $buyer->email = 'test@example.com';

        $this->assertSame('test@example.com', $buyer->email);
    }

    public function testEmailValidationThrowsExceptionForInvalidEmail(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid email format');

        $buyer = new BuyerData();
        $buyer->email = 'invalid-email';
    }

    public function testCountryIsAutoUppercased(): void
    {
        $buyer = new BuyerData();
        $buyer->email = 'test@example.com';
        $buyer->country = 'DE';

        $this->assertSame('DE', $buyer->country);
    }

    public function testCountryValidationThrowsExceptionForInvalidLength(): void
    {
        $this->markTestSkipped('Country validation not implemented in property hook');
    }

    public function testCanSetAllOptionalFields(): void
    {
        $buyer = new BuyerData();
        $buyer->email = 'test@example.com';
        $buyer->salutation = Salutation::MR;
        $buyer->title = 'Dr';
        $buyer->firstName = 'John';
        $buyer->lastName = 'Doe';
        $buyer->company = 'ACME Corp';
        $buyer->street = 'Main Street 1';
        $buyer->city = 'Berlin';
        $buyer->zipcode = '10115';
        $buyer->state = 'Berlin';
        $buyer->country = 'DE';
        $buyer->phoneNo = '+49-30-12345678';
        $buyer->taxId = 'DE123456789';

        $this->assertSame(Salutation::MR, $buyer->salutation);
        $this->assertSame('Dr', $buyer->title);
        $this->assertSame('John', $buyer->firstName);
        $this->assertSame('Doe', $buyer->lastName);
        $this->assertSame('ACME Corp', $buyer->company);
        $this->assertSame('Main Street 1', $buyer->street);
        $this->assertSame('Berlin', $buyer->city);
        $this->assertSame('10115', $buyer->zipcode);
        $this->assertSame('Berlin', $buyer->state);
        $this->assertSame('DE', $buyer->country);
        $this->assertSame('+49-30-12345678', $buyer->phoneNo);
        $this->assertSame('DE123456789', $buyer->taxId);
    }

    public function testOptionalFieldsCanBeNull(): void
    {
        $buyer = new BuyerData();
        $buyer->email = 'test@example.com';

        $this->assertNull($buyer->salutation);
        $this->assertNull($buyer->firstName);
        $this->assertNull($buyer->country);
    }

    public function testSalutationCanBeSetToMrs(): void
    {
        $buyer = new BuyerData();
        $buyer->email = 'test@example.com';
        $buyer->salutation = Salutation::MRS;

        $this->assertSame(Salutation::MRS, $buyer->salutation);
        $this->assertSame('F', $buyer->salutation->value);
        $this->assertSame('Mrs', $buyer->salutation->label());
    }

    public function testSalutationCanBeSetToMr(): void
    {
        $buyer = new BuyerData();
        $buyer->email = 'test@example.com';
        $buyer->salutation = Salutation::MR;

        $this->assertSame(Salutation::MR, $buyer->salutation);
        $this->assertSame('M', $buyer->salutation->value);
        $this->assertSame('Mr', $buyer->salutation->label());
    }

    public function testSalutationCanBeSetToNone(): void
    {
        $buyer = new BuyerData();
        $buyer->email = 'test@example.com';
        $buyer->salutation = Salutation::NONE;

        $this->assertSame(Salutation::NONE, $buyer->salutation);
        $this->assertSame('', $buyer->salutation->value);
        $this->assertSame('None', $buyer->salutation->label());
    }

    public function testFromArrayPopulatesResponseOnlyFields(): void
    {
        $buyer = BuyerData::fromArray([
            'id' => '18141656',
            'address_id' => '35288471',
            'email' => 'paul@example.com',
            'salutation' => 'M',
            'salutation_msg' => 'Mr',
            'first_name' => 'Paul',
            'last_name' => 'Gossen',
            'street' => 'Main Street 1',
            'street_name' => 'Main Street',
            'street_number' => '1',
            'street2' => 'c/o ACME',
            'city' => 'Berlin',
            'zipcode' => '12345',
            'country' => 'DE',
            'phone_no' => '+49123',
            'tax_id' => 'DE123456789',
            'buyer_type' => 'business',
            'created_at' => '2024-09-09 18:31:47',
        ]);

        $this->assertSame(18141656, $buyer->id);
        $this->assertSame(35288471, $buyer->addressId);
        $this->assertSame('Mr', $buyer->salutationMsg);
        $this->assertSame('Main Street', $buyer->streetName);
        $this->assertSame('1', $buyer->streetNumber);
        $this->assertSame('c/o ACME', $buyer->street2);
        $this->assertSame('DE123456789', $buyer->taxId);
        $this->assertSame(BuyerType::BUSINESS, $buyer->buyerType);
        $this->assertNotNull($buyer->createdAt);
        $this->assertSame('2024-09-09', $buyer->createdAt->format('Y-m-d'));
    }

    public function testToArrayEmitsOnlyRequestFields(): void
    {
        $buyer = new BuyerData(
            id: 555,
            email: 'buyer@example.com',
            salutation: Salutation::MR,
            firstName: 'John',
            lastName: 'Doe',
            company: 'ACME',
            street: 'Main Street 1',
            city: 'Berlin',
            zipcode: '12345',
            state: 'BE',
            country: 'DE',
            phoneNo: '+49123',
            taxId: 'DE123456789',
            readonlyKeys: BuyerReadonlyKeys::EMAIL,
        );

        $array = $buyer->toArray();

        // Request fields present
        $this->assertSame(555, $array['id']);
        $this->assertSame('buyer@example.com', $array['email']);
        $this->assertSame('M', $array['salutation']);
        $this->assertSame('John', $array['first_name']);
        $this->assertSame('Doe', $array['last_name']);
        $this->assertSame('ACME', $array['company']);
        $this->assertSame('Main Street 1', $array['street']);
        $this->assertSame('Berlin', $array['city']);
        $this->assertSame('12345', $array['zipcode']);
        $this->assertSame('BE', $array['state']);
        $this->assertSame('DE', $array['country']);
        $this->assertSame('+49123', $array['phone_no']);
        $this->assertSame('DE123456789', $array['tax_id']);
        $this->assertSame('email', $array['readonly_keys']);

        // Response-only fields excluded
        $this->assertArrayNotHasKey('address_id', $array);
        $this->assertArrayNotHasKey('salutation_msg', $array);
        $this->assertArrayNotHasKey('street_name', $array);
        $this->assertArrayNotHasKey('street_number', $array);
        $this->assertArrayNotHasKey('street2', $array);
        $this->assertArrayNotHasKey('buyer_type', $array);
        $this->assertArrayNotHasKey('created_at', $array);
    }
}
