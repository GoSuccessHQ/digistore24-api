<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Tests\Unit\Request\Eticket;

use GoSuccess\Digistore24\Api\Request\Eticket\ValidateEticketRequest;
use PHPUnit\Framework\TestCase;

final class ValidateEticketRequestTest extends TestCase
{
    public function test_can_create_with_required_ids(): void
    {
        $request = new ValidateEticketRequest(
            eticketId: 'TICKET123',
            templateId: 'TPL1',
            locationId: 'LOC1',
        );

        $this->assertSame('TICKET123', $request->eticketId);
        $this->assertSame('TPL1', $request->templateId);
        $this->assertSame('LOC1', $request->locationId);
    }

    public function test_endpoint_returns_correct_value(): void
    {
        $request = new ValidateEticketRequest(
            eticketId: 'TICKET123',
            templateId: 'TPL1',
            locationId: 'LOC1',
        );

        $this->assertSame('/validateEticket', $request->getEndpoint());
    }

    public function test_to_array_converts_required_fields(): void
    {
        $request = new ValidateEticketRequest(
            eticketId: 'TICKET123',
            templateId: 'TPL1',
            locationId: 'LOC1',
        );

        $array = $request->toArray();
        $this->assertSame('TICKET123', $array['eticket_id']);
        $this->assertSame('TPL1', $array['template_id']);
        $this->assertSame('LOC1', $array['location_id']);
        $this->assertArrayNotHasKey('date', $array);
        $this->assertArrayNotHasKey('seperator', $array);
    }

    public function test_to_array_includes_optional_fields(): void
    {
        $request = new ValidateEticketRequest(
            eticketId: 'TICKET123',
            templateId: 'TPL1',
            locationId: 'LOC1',
            date: new \DateTimeImmutable('2024-06-15'),
            seperator: ', ',
        );

        $array = $request->toArray();
        $this->assertSame('2024-06-15', $array['date']);
        $this->assertSame(', ', $array['seperator']);
    }

    public function test_validation_passes_for_valid_data(): void
    {
        $request = new ValidateEticketRequest(
            eticketId: 'TICKET123',
            templateId: 'TPL1',
            locationId: 'LOC1',
        );

        $errors = $request->validate();
        $this->assertEmpty($errors);
    }
}
