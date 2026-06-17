<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Tests\Unit\Response\ServiceProof;

use GoSuccess\Digistore24\Api\Http\Response;
use GoSuccess\Digistore24\Api\Response\ServiceProof\UpdateServiceProofRequestResponse;
use PHPUnit\Framework\TestCase;

final class UpdateServiceProofRequestResponseTest extends TestCase
{
    public function test_can_create_from_array(): void
    {
        $data = [
            'result' => 'success',
            'data' => [
                'is_modified' => 'Y',
            ],
        ];
        $response = UpdateServiceProofRequestResponse::fromArray($data);

        $this->assertInstanceOf(UpdateServiceProofRequestResponse::class, $response);
        $this->assertTrue($response->isModified);
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

        $response = UpdateServiceProofRequestResponse::fromResponse($httpResponse);

        $this->assertInstanceOf(UpdateServiceProofRequestResponse::class, $response);
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

        $response = UpdateServiceProofRequestResponse::fromResponse($httpResponse);

        $this->assertInstanceOf(Response::class, $response->rawResponse);
    }
}
