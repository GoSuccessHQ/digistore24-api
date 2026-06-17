<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Tests\Unit\Response\Country;

use GoSuccess\Digistore24\Api\Http\Response;
use GoSuccess\Digistore24\Api\Response\Country\ListCountriesResponse;
use PHPUnit\Framework\TestCase;

final class ListCountriesResponseTest extends TestCase
{
    public function test_can_create_from_array(): void
    {
        $data = [
            'data' => [
                'DE' => 'Germany',
                'US' => 'United States',
                'FR' => 'France',
            ],
        ];
        $response = ListCountriesResponse::fromArray($data);

        $this->assertInstanceOf(ListCountriesResponse::class, $response);
        $this->assertCount(3, $response->countries);
        $this->assertSame(3, $response->total);
        $this->assertSame('DE', $response->countries[0]->code);
        $this->assertSame('Germany', $response->countries[0]->name);
        $this->assertSame('Germany', $response->countryMap['DE']);
        $this->assertSame('United States', $response->countryMap['US']);
    }

    public function test_can_create_from_response(): void
    {
        $httpResponse = new Response(
            statusCode: 200,
            data: [
                'data' => [
                    'DE' => 'Germany',
                    'US' => 'United States',
                ],
            ],
            headers: [],
            rawBody: '',
        );

        $response = ListCountriesResponse::fromResponse($httpResponse);

        $this->assertInstanceOf(ListCountriesResponse::class, $response);
        $this->assertCount(2, $response->countries);
        $this->assertSame(2, $response->total);
    }

    public function test_has_raw_response(): void
    {
        $httpResponse = new Response(
            statusCode: 200,
            data: [],
            headers: [],
            rawBody: 'test',
        );

        $response = ListCountriesResponse::fromResponse($httpResponse);

        $this->assertInstanceOf(Response::class, $response->rawResponse);
    }
}
