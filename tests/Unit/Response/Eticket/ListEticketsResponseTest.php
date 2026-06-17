<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Tests\Unit\Response\Eticket;

use GoSuccess\Digistore24\Api\Http\Response;
use GoSuccess\Digistore24\Api\Response\Eticket\EticketListItem;
use GoSuccess\Digistore24\Api\Response\Eticket\ListEticketsResponse;
use PHPUnit\Framework\TestCase;

final class ListEticketsResponseTest extends TestCase
{
    /**
     * @param int $id
     * @param string $firstName
     * @return array<string, mixed>
     */
    private function ticket(int $id, string $firstName): array
    {
        return [
            'id' => $id,
            'download_url' => "https://example.com/ticket/{$id}.pdf",
            'duration' => null,
            'date_id' => 7,
            'date' => '2024-06-15',
            'hint' => '09:00',
            'location_id' => 1001,
            'template_id' => 2002,
            'purchase_item_id' => 3003,
            'no' => 1,
            'count' => 1,
            'email' => 'buyer@example.com',
            'first_name' => $firstName,
            'last_name' => 'Doe',
            'salutation' => 'M',
            'title' => null,
            'language' => 'en',
            'used_at' => null,
            'is_blocked' => 'N',
            'note' => null,
            'product_id' => 12345,
        ];
    }

    public function test_can_create_from_array_with_etickets(): void
    {
        $data = [
            'etickets' => [
                $this->ticket(1, 'John'),
            ],
        ];

        $response = ListEticketsResponse::fromArray($data);

        $this->assertCount(1, $response->etickets);
        $this->assertInstanceOf(EticketListItem::class, $response->etickets[0]);
        $this->assertSame(1, $response->etickets[0]->id);
        $this->assertSame('John', $response->etickets[0]->firstName);
    }

    public function test_can_create_from_response(): void
    {
        $httpResponse = new Response(
            200,
            ['data' => [
                'etickets' => [
                    $this->ticket(99, 'Jane'),
                ],
            ]],
        );

        $response = ListEticketsResponse::fromResponse($httpResponse);

        $this->assertCount(1, $response->etickets);
        $this->assertSame('Jane', $response->etickets[0]->firstName);
        $this->assertSame(99, $response->etickets[0]->id);
    }

    public function test_handles_empty_etickets_array(): void
    {
        $response = ListEticketsResponse::fromArray(['etickets' => []]);

        $this->assertCount(0, $response->etickets);
    }

    public function test_handles_missing_etickets_key(): void
    {
        $response = ListEticketsResponse::fromArray([]);

        $this->assertCount(0, $response->etickets);
    }

    public function test_eticket_list_item_from_array(): void
    {
        $item = EticketListItem::fromArray($this->ticket(333, 'Bob'));

        $this->assertSame(333, $item->id);
        $this->assertSame('Bob', $item->firstName);
        $this->assertNull($item->duration);
        $this->assertFalse($item->isBlocked);
        $this->assertNull($item->usedAt);
        $this->assertInstanceOf(\DateTimeInterface::class, $item->date);
    }

    public function test_handles_multiple_etickets(): void
    {
        $data = [
            'etickets' => [
                $this->ticket(1, 'Alice'),
                $this->ticket(2, 'Charlie'),
            ],
        ];

        $response = ListEticketsResponse::fromArray($data);

        $this->assertCount(2, $response->etickets);
        $this->assertSame('Alice', $response->etickets[0]->firstName);
        $this->assertSame('Charlie', $response->etickets[1]->firstName);
    }
}
