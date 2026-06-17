<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Tests\Unit\Response\Image;

use GoSuccess\Digistore24\Api\Http\Response;
use GoSuccess\Digistore24\Api\Response\Image\GetImageResponse;
use PHPUnit\Framework\TestCase;

final class GetImageResponseTest extends TestCase
{
    public function test_can_create_from_array(): void
    {
        $data = [
            'image' => [
                'id' => 'IMG123',
                'url' => 'https://example.com/images/123.jpg',
                'type' => 'product',
                'properties' => [
                    'width' => 100,
                    'height' => 100,
                ],
            ],
        ];
        $response = GetImageResponse::fromArray($data);

        $this->assertInstanceOf(GetImageResponse::class, $response);
        $this->assertSame('IMG123', $response->id);
        $this->assertSame('https://example.com/images/123.jpg', $response->url);
        $this->assertSame('product', $response->type);
        $this->assertSame(100, $response->properties['width']);
    }

    public function test_can_create_from_response(): void
    {
        $httpResponse = new Response(
            statusCode: 200,
            data: [
                'data' => [
                    'image' => [
                        'id' => 'IMG456',
                        'url' => 'https://example.com/images/456.jpg',
                        'type' => 'logo',
                    ],
                ],
            ],
            headers: [],
            rawBody: '',
        );

        $response = GetImageResponse::fromResponse($httpResponse);

        $this->assertInstanceOf(GetImageResponse::class, $response);
        $this->assertSame('IMG456', $response->id);
        $this->assertSame('logo', $response->type);
    }

    public function test_has_raw_response(): void
    {
        $httpResponse = new Response(
            statusCode: 200,
            data: [],
            headers: [],
            rawBody: 'test',
        );

        $response = GetImageResponse::fromResponse($httpResponse);

        $this->assertInstanceOf(Response::class, $response->rawResponse);
    }
}
