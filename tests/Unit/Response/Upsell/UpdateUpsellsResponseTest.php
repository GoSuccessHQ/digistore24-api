<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Tests\Unit\Response\Upsell;

use GoSuccess\Digistore24\Api\Http\Response;
use GoSuccess\Digistore24\Api\Response\Upsell\UpdateUpsellsResponse;
use PHPUnit\Framework\TestCase;

final class UpdateUpsellsResponseTest extends TestCase
{
    public function test_can_create_from_array(): void
    {
        $data = [
            'result' => 'success',
            'data' => [
                'is_modified' => 'Y',
            ],
        ];
        $response = UpdateUpsellsResponse::fromArray($data);

        $this->assertInstanceOf(UpdateUpsellsResponse::class, $response);
        $this->assertTrue($response->isModified);
        $this->assertTrue($response->wasSuccessful());
    }

    public function test_can_create_from_response(): void
    {
        $httpResponse = new Response(
            statusCode: 200,
            data: [
                'result' => 'success',
                'data' => [
                    'is_modified' => 'N',
                ],
            ],
            headers: [],
            rawBody: '',
        );

        $response = UpdateUpsellsResponse::fromResponse($httpResponse);

        $this->assertInstanceOf(UpdateUpsellsResponse::class, $response);
        $this->assertFalse($response->isModified);
    }

    public function test_has_raw_response(): void
    {
        $httpResponse = new Response(
            statusCode: 200,
            data: [
                'result' => 'success',
            ],
            headers: [],
            rawBody: 'test',
        );

        $response = UpdateUpsellsResponse::fromResponse($httpResponse);

        $this->assertInstanceOf(Response::class, $response->rawResponse);
    }
}
