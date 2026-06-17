<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Tests\Unit\Response\Eticket;

use GoSuccess\Digistore24\Api\Http\Response;
use GoSuccess\Digistore24\Api\Response\Eticket\GetEticketSettingsResponse;
use PHPUnit\Framework\TestCase;

final class GetEticketSettingsResponseTest extends TestCase
{
    public function test_can_create_from_array(): void
    {
        $data = [
            'eticket_owners' => [
                '12345' => 'Owner One',
            ],
            'eticket_templates' => [
                '12345' => ['200' => 'Some seminar'],
            ],
            'eticket_locations' => [
                '12345' => ['300' => 'Berlin'],
            ],
        ];
        $response = GetEticketSettingsResponse::fromArray($data);

        $this->assertInstanceOf(GetEticketSettingsResponse::class, $response);
        $this->assertSame(['12345' => 'Owner One'], $response->eticketOwners);
        $this->assertSame(['12345' => ['200' => 'Some seminar']], $response->eticketTemplates);
        $this->assertSame(['12345' => ['300' => 'Berlin']], $response->eticketLocations);
        $this->assertArrayHasKey('eticket_owners', $response->data);
    }

    public function test_can_create_from_response(): void
    {
        $httpResponse = new Response(
            statusCode: 200,
            data: [
                'eticket_owners' => ['1' => 'Owner'],
                'eticket_templates' => [],
                'eticket_locations' => [],
            ],
            headers: [],
            rawBody: '',
        );

        $response = GetEticketSettingsResponse::fromResponse($httpResponse);

        $this->assertInstanceOf(GetEticketSettingsResponse::class, $response);
        $this->assertSame(['1' => 'Owner'], $response->eticketOwners);
    }

    public function test_has_raw_response(): void
    {
        $httpResponse = new Response(
            statusCode: 200,
            data: [],
            headers: [],
            rawBody: 'test',
        );

        $response = GetEticketSettingsResponse::fromResponse($httpResponse);

        $this->assertInstanceOf(Response::class, $response->rawResponse);
    }
}
