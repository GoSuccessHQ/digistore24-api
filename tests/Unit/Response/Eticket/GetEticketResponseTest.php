<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Tests\Unit\Response\Eticket;

use GoSuccess\Digistore24\Api\Http\Response;
use GoSuccess\Digistore24\Api\Response\Eticket\EticketDetail;
use GoSuccess\Digistore24\Api\Response\Eticket\GetEticketResponse;
use PHPUnit\Framework\TestCase;

final class GetEticketResponseTest extends TestCase
{
    /** @return array<string, mixed> */
    private function sampleEticket(): array
    {
        return [
            'id' => 42,
            'download_url' => 'https://example.com/ticket/42.pdf',
            'duration' => '1 day',
            'date_id' => 7,
            'date' => '2024-06-15',
            'hint' => '09:00 - 17:00',
            'location_id' => 1001,
            'template_id' => 2002,
            'purchase_item_id' => 3003,
            'no' => 1,
            'count' => 2,
            'email' => 'buyer@example.com',
            'first_name' => 'John',
            'last_name' => 'Doe',
            'salutation' => 'M',
            'title' => 'Dr.',
            'language' => 'en',
            'used_at' => null,
            'is_blocked' => 'N',
            'note' => 'VIP',
            'product_id' => 12345,
        ];
    }

    public function test_can_create_from_array(): void
    {
        $response = GetEticketResponse::fromArray(['eticket' => $this->sampleEticket()]);

        $this->assertInstanceOf(EticketDetail::class, $response->eticket);
        $this->assertSame(42, $response->eticket->id);
        $this->assertSame('https://example.com/ticket/42.pdf', $response->eticket->downloadUrl);
        $this->assertSame(1001, $response->eticket->locationId);
        $this->assertSame('John', $response->eticket->firstName);
        $this->assertSame(12345, $response->eticket->productId);
        $this->assertArrayHasKey('hint', $response->data);
    }

    public function test_can_create_from_response(): void
    {
        $httpResponse = new Response(
            200,
            ['data' => ['eticket' => [
                'id' => 99,
                'download_url' => 'https://example.com/ticket/99.pdf',
                'location_id' => 2,
                'template_id' => 3,
                'date' => '2024-07-20',
                'used_at' => '2024-07-20 09:15:00',
                'is_blocked' => 'Y',
                'product_id' => 67890,
            ]]],
        );

        $response = GetEticketResponse::fromResponse($httpResponse);

        $this->assertSame(99, $response->eticket->id);
        $this->assertTrue($response->eticket->isBlocked);
        $this->assertInstanceOf(\DateTimeInterface::class, $response->eticket->usedAt);
        $this->assertInstanceOf(\DateTimeInterface::class, $response->eticket->date);
    }

    public function test_eticket_detail_from_array(): void
    {
        $detail = EticketDetail::fromArray($this->sampleEticket());

        $this->assertSame(42, $detail->id);
        $this->assertSame('1 day', $detail->duration);
        $this->assertSame('VIP', $detail->note);
        $this->assertSame('Dr.', $detail->title);
        $this->assertFalse($detail->isBlocked);
        $this->assertNull($detail->usedAt);
        $this->assertInstanceOf(\DateTimeInterface::class, $detail->date);
    }

    public function test_handles_used_ticket(): void
    {
        $data = $this->sampleEticket();
        $data['used_at'] = '2024-09-01 18:30:00';
        $data['is_blocked'] = 'Y';

        $detail = EticketDetail::fromArray($data);

        $this->assertTrue($detail->isBlocked);
        $this->assertInstanceOf(\DateTimeInterface::class, $detail->usedAt);
        $this->assertSame('2024-09-01 18:30:00', $detail->usedAt->format('Y-m-d H:i:s'));
    }
}
