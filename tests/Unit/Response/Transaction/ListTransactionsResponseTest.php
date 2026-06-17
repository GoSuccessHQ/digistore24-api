<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Tests\Unit\Response\Transaction;

use GoSuccess\Digistore24\Api\DTO\TransactionBuyerData;
use GoSuccess\Digistore24\Api\DTO\TransactionData;
use GoSuccess\Digistore24\Api\DTO\TransactionSummaryAmountData;
use GoSuccess\Digistore24\Api\DTO\TransactionSummaryData;
use GoSuccess\Digistore24\Api\Http\Response;
use GoSuccess\Digistore24\Api\Response\Transaction\ListTransactionsResponse;
use PHPUnit\Framework\TestCase;

final class ListTransactionsResponseTest extends TestCase
{
    /**
     * @return array<string, mixed>
     */
    private function sampleData(): array
    {
        return [
            'result' => 'success',
            'data' => [
                'from' => '2024-01-01 00:00:00',
                'to' => '2024-01-31 23:59:59',
                'page_size' => 500,
                'page_no' => 1,
                'page_count' => 3,
                'summary' => [
                    'amounts' => [
                        'EUR' => [
                            'count' => 2,
                            'total_amount' => 149.49,
                            'vat_amount' => 23.86,
                            'earned_amount' => 120.00,
                        ],
                        'USD' => [
                            'count' => 1,
                            'total_amount' => 49.50,
                            'vat_amount' => 0.0,
                            'earned_amount' => 40.00,
                        ],
                    ],
                    'count' => 3,
                ],
                'transaction_list' => [
                    [
                        'id' => 1001,
                        'purchase_id' => 'ABCDEFGH',
                        'amount' => 99.99,
                        'currency' => 'EUR',
                        'transaction_type' => 'payment',
                        'transaction_type_msg' => 'Payment',
                        'created_at' => '2024-01-15 10:30:00',
                        'buyer' => [
                            'id' => 555,
                            'email' => 'buyer@example.com',
                            'first_name' => 'Jane',
                            'last_name' => 'Doe',
                        ],
                    ],
                    [
                        'id' => 1002,
                        'purchase_id' => 'IJKLMNOP',
                        'amount' => 49.50,
                        'currency' => 'USD',
                        'transaction_type' => 'refund',
                        'transaction_type_msg' => 'Refund',
                        'created_at' => '2024-01-16 12:00:00',
                        'buyer' => [
                            'id' => 556,
                            'email' => 'other@example.com',
                            'first_name' => 'John',
                            'last_name' => 'Smith',
                        ],
                    ],
                ],
            ],
        ];
    }

    public function test_can_create_from_array(): void
    {
        $response = ListTransactionsResponse::fromArray($this->sampleData());

        $this->assertInstanceOf(ListTransactionsResponse::class, $response);
        $this->assertSame('success', $response->result);
        $this->assertCount(2, $response->transactionList);
    }

    public function test_pagination_fields_are_typed(): void
    {
        $response = ListTransactionsResponse::fromArray($this->sampleData());

        $this->assertInstanceOf(\DateTimeImmutable::class, $response->from);
        $this->assertSame('2024-01-01 00:00:00', $response->from->format('Y-m-d H:i:s'));
        $this->assertInstanceOf(\DateTimeImmutable::class, $response->to);
        $this->assertSame('2024-01-31 23:59:59', $response->to->format('Y-m-d H:i:s'));
        $this->assertSame(500, $response->pageSize);
        $this->assertSame(1, $response->pageNo);
        $this->assertSame(3, $response->pageCount);
    }

    public function test_transaction_list_items_are_typed_dtos(): void
    {
        $response = ListTransactionsResponse::fromArray($this->sampleData());

        $first = $response->transactionList[0];
        $this->assertInstanceOf(TransactionData::class, $first);
        $this->assertSame(1001, $first->id);
        $this->assertSame('ABCDEFGH', $first->purchaseId);
        $this->assertSame(99.99, $first->amount);
        $this->assertSame('EUR', $first->currency);
        $this->assertSame('payment', $first->transactionType);
        $this->assertSame('Payment', $first->transactionTypeMsg);
        $this->assertInstanceOf(\DateTimeImmutable::class, $first->createdAt);
        $this->assertSame('2024-01-15 10:30:00', $first->createdAt->format('Y-m-d H:i:s'));
    }

    public function test_transaction_buyer_is_typed_dto(): void
    {
        $response = ListTransactionsResponse::fromArray($this->sampleData());

        $buyer = $response->transactionList[0]->buyer;
        $this->assertInstanceOf(TransactionBuyerData::class, $buyer);
        $this->assertSame(555, $buyer->id);
        $this->assertSame('buyer@example.com', $buyer->email);
        $this->assertSame('Jane', $buyer->firstName);
        $this->assertSame('Doe', $buyer->lastName);
    }

    public function test_summary_is_typed_dto(): void
    {
        $response = ListTransactionsResponse::fromArray($this->sampleData());

        $summary = $response->summary;
        $this->assertInstanceOf(TransactionSummaryData::class, $summary);
        $this->assertSame(3, $summary->count);
        $this->assertArrayHasKey('EUR', $summary->amounts);
        $this->assertArrayHasKey('USD', $summary->amounts);

        $eur = $summary->amounts['EUR'];
        $this->assertInstanceOf(TransactionSummaryAmountData::class, $eur);
        $this->assertSame(2, $eur->count);
        $this->assertSame(149.49, $eur->totalAmount);
        $this->assertSame(23.86, $eur->vatAmount);
        $this->assertSame(120.00, $eur->earnedAmount);
    }

    public function test_data_holds_full_inner_payload(): void
    {
        $response = ListTransactionsResponse::fromArray($this->sampleData());

        $this->assertArrayHasKey('transaction_list', $response->data);
        $this->assertArrayHasKey('summary', $response->data);
        $this->assertSame(3, $response->data['page_count']);
    }

    public function test_can_create_from_response(): void
    {
        $httpResponse = new Response(
            statusCode: 200,
            data: [
                'result' => 'success',
                'data' => [
                    'page_no' => 1,
                    'transaction_list' => [
                        [
                            'id' => 999,
                            'purchase_id' => 'ZZZZ',
                            'amount' => 29.99,
                            'currency' => 'EUR',
                        ],
                    ],
                ],
            ],
            headers: [],
            rawBody: '',
        );

        $response = ListTransactionsResponse::fromResponse($httpResponse);

        $this->assertInstanceOf(ListTransactionsResponse::class, $response);
        $this->assertCount(1, $response->transactionList);
        $this->assertSame(999, $response->transactionList[0]->id);
    }

    public function test_has_raw_response(): void
    {
        $httpResponse = new Response(
            statusCode: 200,
            data: [
                'data' => [
                    'transaction_list' => [],
                ],
            ],
            headers: [],
            rawBody: 'test',
        );

        $response = ListTransactionsResponse::fromResponse($httpResponse);

        $this->assertInstanceOf(Response::class, $response->rawResponse);
        $this->assertSame([], $response->transactionList);
        $this->assertNull($response->summary);
    }
}
