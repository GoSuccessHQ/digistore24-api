<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Tests\Unit\Response\Eticket;

use GoSuccess\Digistore24\Api\Http\Response;
use GoSuccess\Digistore24\Api\Response\Eticket\EticketTemplate;
use GoSuccess\Digistore24\Api\Response\Eticket\ListEticketTemplatesResponse;
use PHPUnit\Framework\TestCase;

final class ListEticketTemplatesResponseTest extends TestCase
{
    public function test_can_create_from_bare_array(): void
    {
        $data = [
            [
                'id' => 123,
                'name' => 'Standard Ticket',
                'created_at' => '2024-01-15 10:00:00',
                'modified_at' => '2024-02-01 12:00:00',
            ],
        ];
        // @phpstan-ignore argument.type
        $response = ListEticketTemplatesResponse::fromArray($data);

        $this->assertInstanceOf(ListEticketTemplatesResponse::class, $response);
        $this->assertCount(1, $response->templates);
        $this->assertInstanceOf(EticketTemplate::class, $response->templates[0]);
        $this->assertSame(123, $response->templates[0]->id);
        $this->assertSame('Standard Ticket', $response->templates[0]->name);
        $this->assertInstanceOf(\DateTimeInterface::class, $response->templates[0]->createdAt);
        $this->assertInstanceOf(\DateTimeInterface::class, $response->templates[0]->modifiedAt);
    }

    public function test_can_create_from_response(): void
    {
        $httpResponse = new Response(
            statusCode: 200,
            data: [
                'result' => 'success',
                'data' => [
                    ['id' => 123, 'name' => 'Standard Ticket'],
                ],
            ],
            headers: [],
            rawBody: '',
        );

        $response = ListEticketTemplatesResponse::fromResponse($httpResponse);

        $this->assertInstanceOf(ListEticketTemplatesResponse::class, $response);
        $this->assertCount(1, $response->templates);
        $this->assertSame('Standard Ticket', $response->templates[0]->name);
    }

    public function test_has_raw_response(): void
    {
        $httpResponse = new Response(
            statusCode: 200,
            data: [],
            headers: [],
            rawBody: 'test',
        );

        $response = ListEticketTemplatesResponse::fromResponse($httpResponse);

        $this->assertInstanceOf(Response::class, $response->rawResponse);
    }
}
