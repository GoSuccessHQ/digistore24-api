<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Tests\Unit\Response\Eticket;

use GoSuccess\Digistore24\Api\Http\Response;
use GoSuccess\Digistore24\Api\Response\Eticket\ValidateEticketResponse;
use PHPUnit\Framework\TestCase;

final class ValidateEticketResponseTest extends TestCase
{
    public function test_can_create_from_array(): void
    {
        $data = [
            'status' => 'success',
            'msg' => 'Ticket validated successfully',
            'eticket_location_id' => 1001,
            'eticket_template_id' => 2002,
            'eticket_date' => '2024-06-15',
            'is_eticket_valid_for_different_event' => 'N',
            'valid_ticket_count' => 3,
            'used_ticket_count' => 1,
        ];

        $response = ValidateEticketResponse::fromArray($data);

        $this->assertSame('success', $response->status);
        $this->assertSame('Ticket validated successfully', $response->msg);
        $this->assertSame(1001, $response->eticketLocationId);
        $this->assertSame(2002, $response->eticketTemplateId);
        $this->assertInstanceOf(\DateTimeInterface::class, $response->eticketDate);
        $this->assertFalse($response->isEticketValidForDifferentEvent);
        $this->assertSame(3, $response->validTicketCount);
        $this->assertSame(1, $response->usedTicketCount);
        $this->assertArrayHasKey('msg', $response->data);
    }

    public function test_can_create_from_response(): void
    {
        $httpResponse = new Response(
            200,
            ['data' => [
                'status' => 'error',
                'msg' => 'Ticket not valid',
                'eticket_location_id' => 5,
                'eticket_template_id' => 6,
                'eticket_date' => '2024-07-20',
                'is_eticket_valid_for_different_event' => 'Y',
                'valid_ticket_count' => 0,
                'used_ticket_count' => 0,
            ]],
        );

        $response = ValidateEticketResponse::fromResponse($httpResponse);

        $this->assertSame('error', $response->status);
        $this->assertSame('Ticket not valid', $response->msg);
        $this->assertTrue($response->isEticketValidForDifferentEvent);
    }

    public function test_handles_missing_optional_fields(): void
    {
        $data = [
            'status' => 'success',
            'msg' => 'OK',
        ];

        $response = ValidateEticketResponse::fromArray($data);

        $this->assertSame(0, $response->eticketLocationId);
        $this->assertSame(0, $response->validTicketCount);
        $this->assertFalse($response->isEticketValidForDifferentEvent);
        $this->assertNull($response->eticketDate);
    }
}
