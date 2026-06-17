<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Tests\Unit\Response\OrderForm;

use GoSuccess\Digistore24\Api\Http\Response;
use GoSuccess\Digistore24\Api\Response\OrderForm\GetOrderformMetasResponse;
use PHPUnit\Framework\TestCase;

final class GetOrderformMetasResponseTest extends TestCase
{
    public function test_can_create_from_array(): void
    {
        $data = [
            'data' => [
                'placeholders' => [
                    'images' => ['logo' => 'Logo'],
                    'other' => ['name' => 'Name'],
                ],
                'options' => [
                    'background_style' => ['white' => 'White', 'blue' => 'Blue'],
                    'step_count' => ['1' => 'One', '2' => 'Two', '3' => 'Three'],
                ],
                'form_metas' => ['extra' => 'value'],
            ],
        ];
        $response = GetOrderformMetasResponse::fromArray($data);

        $this->assertInstanceOf(GetOrderformMetasResponse::class, $response);
        $this->assertArrayHasKey('images', $response->placeholders);
        $this->assertArrayHasKey('background_style', $response->options);
        $this->assertSame('value', $response->formMetas['extra']);
        $this->assertArrayHasKey('placeholders', $response->data);
    }

    public function test_can_create_from_response(): void
    {
        $httpResponse = new Response(
            statusCode: 200,
            data: [
                'data' => [
                    'data' => [
                        'placeholders' => ['other' => ['name' => 'Name']],
                        'options' => ['tab_style' => ['bigtabs' => 'Big Tabs']],
                        'form_metas' => [],
                    ],
                ],
            ],
            headers: [],
            rawBody: '',
        );

        $response = GetOrderformMetasResponse::fromResponse($httpResponse);

        $this->assertInstanceOf(GetOrderformMetasResponse::class, $response);
        $this->assertArrayHasKey('tab_style', $response->options);
    }

    public function test_has_raw_response(): void
    {
        $httpResponse = new Response(
            statusCode: 200,
            data: [],
            headers: [],
            rawBody: 'test',
        );

        $response = GetOrderformMetasResponse::fromResponse($httpResponse);

        $this->assertInstanceOf(Response::class, $response->rawResponse);
    }
}
