<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Tests\Unit\Response\Image;

use GoSuccess\Digistore24\Api\Http\Response;
use GoSuccess\Digistore24\Api\Response\Image\ImageListItem;
use GoSuccess\Digistore24\Api\Response\Image\ListImagesResponse;
use PHPUnit\Framework\TestCase;

final class ListImagesResponseTest extends TestCase
{
    public function test_can_create_from_array(): void
    {
        $data = [
            'images' => [
                [
                    'id' => '05CZEP6G',
                    'url' => 'https://cdn.example.com/merchant_1/image/product/05CZEP6G',
                    'file_extension' => 'png',
                    'name' => 'Product 1',
                    'approval_status' => 'approved',
                    'usage_type' => 'product',
                    'alt_tag' => 'A product',
                    'width' => 100,
                    'height' => 80,
                ],
                [
                    'id' => '071VX0KZ',
                    'url' => 'https://cdn.example.com/merchant_1/image/product/071VX0KZ',
                    'file_extension' => 'jpg',
                    'name' => 'Banner 2',
                    'approval_status' => 'approved',
                    'usage_type' => 'product',
                    'alt_tag' => null,
                    'width' => 200,
                    'height' => 100,
                ],
            ],
        ];
        $response = ListImagesResponse::fromArray($data);

        $this->assertInstanceOf(ListImagesResponse::class, $response);
        $this->assertCount(2, $response->images);
        $this->assertSame(2, $response->totalCount);
        $this->assertInstanceOf(ImageListItem::class, $response->images[0]);
        $this->assertSame('05CZEP6G', $response->images[0]->id);
        $this->assertSame('png', $response->images[0]->fileExtension);
        $this->assertSame('product', $response->images[0]->usageType);
        $this->assertSame(100, $response->images[0]->width);
        $this->assertNull($response->images[1]->altTag);
    }

    public function test_can_create_from_response(): void
    {
        $httpResponse = new Response(
            statusCode: 200,
            data: [
                'data' => [
                    'images' => [
                        [
                            'id' => 'LOGO01',
                            'url' => 'https://cdn.example.com/logo.png',
                            'file_extension' => 'png',
                            'name' => 'Logo',
                            'usage_type' => 'logo',
                        ],
                    ],
                ],
            ],
            headers: [],
            rawBody: '',
        );

        $response = ListImagesResponse::fromResponse($httpResponse);

        $this->assertInstanceOf(ListImagesResponse::class, $response);
        $this->assertCount(1, $response->images);
        $this->assertSame('LOGO01', $response->images[0]->id);
    }

    public function test_has_raw_response(): void
    {
        $httpResponse = new Response(
            statusCode: 200,
            data: [],
            headers: [],
            rawBody: 'test',
        );

        $response = ListImagesResponse::fromResponse($httpResponse);

        $this->assertInstanceOf(Response::class, $response->rawResponse);
    }
}
