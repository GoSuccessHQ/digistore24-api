<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Tests\Unit\Response\Eticket;

use GoSuccess\Digistore24\Api\Http\Response;
use GoSuccess\Digistore24\Api\Response\Eticket\EticketLocation;
use GoSuccess\Digistore24\Api\Response\Eticket\ListEticketLocationsResponse;
use PHPUnit\Framework\TestCase;

final class ListEticketLocationsResponseTest extends TestCase
{
    public function test_can_create_from_bare_array(): void
    {
        $data = [
            ['id' => 123, 'name' => 'Convention Center', 'address' => '123 Main St, Berlin'],
            ['id' => 124, 'name' => 'Town Hall', 'address' => '5 Market Sq'],
        ];
        // @phpstan-ignore argument.type
        $response = ListEticketLocationsResponse::fromArray($data);

        $this->assertInstanceOf(ListEticketLocationsResponse::class, $response);
        $this->assertCount(2, $response->locations);
        $this->assertInstanceOf(EticketLocation::class, $response->locations[0]);
        $this->assertSame(123, $response->locations[0]->id);
        $this->assertSame('Convention Center', $response->locations[0]->name);
        $this->assertSame('123 Main St, Berlin', $response->locations[0]->address);
    }

    public function test_can_create_from_response(): void
    {
        $httpResponse = new Response(
            statusCode: 200,
            data: [
                'result' => 'success',
                'data' => [
                    ['id' => 123, 'name' => 'Convention Center', 'address' => 'Berlin'],
                ],
            ],
            headers: [],
            rawBody: '',
        );

        $response = ListEticketLocationsResponse::fromResponse($httpResponse);

        $this->assertInstanceOf(ListEticketLocationsResponse::class, $response);
        $this->assertCount(1, $response->locations);
        $this->assertSame('Convention Center', $response->locations[0]->name);
    }

    public function test_has_raw_response(): void
    {
        $httpResponse = new Response(
            statusCode: 200,
            data: [],
            headers: [],
            rawBody: 'test',
        );

        $response = ListEticketLocationsResponse::fromResponse($httpResponse);

        $this->assertInstanceOf(Response::class, $response->rawResponse);
    }
}
