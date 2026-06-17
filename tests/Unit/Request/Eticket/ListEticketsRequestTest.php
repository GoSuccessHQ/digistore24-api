<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Tests\Unit\Request\Eticket;

use GoSuccess\Digistore24\Api\Request\Eticket\ListEticketsRequest;
use PHPUnit\Framework\TestCase;

final class ListEticketsRequestTest extends TestCase
{
    public function test_can_create_with_no_filters(): void
    {
        $request = new ListEticketsRequest();

        $this->assertNull($request->ownerId);
        $this->assertNull($request->purchaseId);
        $this->assertNull($request->firstName);
        $this->assertNull($request->lastName);
        $this->assertNull($request->email);
        $this->assertNull($request->templateId);
        $this->assertNull($request->locationId);
        $this->assertNull($request->date);
    }

    public function test_can_create_with_purchase_filter(): void
    {
        $request = new ListEticketsRequest(
            purchaseId: '12345',
        );

        $this->assertSame('12345', $request->purchaseId);
    }

    public function test_can_create_with_location_filter(): void
    {
        $request = new ListEticketsRequest(
            locationId: 'LOC001',
        );

        $this->assertSame('LOC001', $request->locationId);
    }

    public function test_can_create_with_date_filter(): void
    {
        $date = new \DateTimeImmutable('2024-01-01');

        $request = new ListEticketsRequest(
            date: $date,
        );

        $this->assertSame($date, $request->date);
    }

    public function test_can_create_with_all_filters(): void
    {
        $date = new \DateTimeImmutable('2024-06-01');

        $request = new ListEticketsRequest(
            ownerId: 'OWN1',
            purchaseId: '12345',
            firstName: 'John',
            lastName: 'Doe',
            email: 'john@example.com',
            templateId: 'TPL1',
            locationId: 'LOC001',
            date: $date,
        );

        $this->assertSame('OWN1', $request->ownerId);
        $this->assertSame('12345', $request->purchaseId);
        $this->assertSame('John', $request->firstName);
        $this->assertSame('Doe', $request->lastName);
        $this->assertSame('john@example.com', $request->email);
        $this->assertSame('TPL1', $request->templateId);
        $this->assertSame('LOC001', $request->locationId);
        $this->assertSame($date, $request->date);
    }

    public function test_endpoint_returns_correct_value(): void
    {
        $request = new ListEticketsRequest();

        $this->assertSame('/listEtickets', $request->getEndpoint());
    }

    public function test_to_array_with_no_filters(): void
    {
        $request = new ListEticketsRequest();

        $array = $request->toArray();
        $this->assertEmpty($array);
    }

    public function test_to_array_wraps_filters_in_search(): void
    {
        $request = new ListEticketsRequest(
            purchaseId: '12345',
            locationId: 'LOC001',
        );

        $array = $request->toArray();

        $this->assertArrayHasKey('search', $array);
        $search = $array['search'];
        $this->assertIsArray($search);
        $this->assertSame('12345', $search['purchase_id']);
        $this->assertSame('LOC001', $search['location_id']);
    }

    public function test_to_array_with_date_filter(): void
    {
        $date = new \DateTimeImmutable('2024-01-15');

        $request = new ListEticketsRequest(
            date: $date,
        );

        $array = $request->toArray();
        $search = $array['search'];
        $this->assertIsArray($search);
        $this->assertSame('2024-01-15', $search['date']);
    }

    public function test_validation_passes_for_valid_data(): void
    {
        $request = new ListEticketsRequest(
            purchaseId: '12345',
        );

        $errors = $request->validate();
        $this->assertEmpty($errors);
    }
}
