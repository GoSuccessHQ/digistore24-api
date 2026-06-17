<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Tests\Unit\Response\CustomForm;

use GoSuccess\Digistore24\Api\Http\Response;
use GoSuccess\Digistore24\Api\Response\CustomForm\ListCustomFormRecordsResponse;
use PHPUnit\Framework\TestCase;

final class ListCustomFormRecordsResponseTest extends TestCase
{
    public function test_can_create_from_array(): void
    {
        $data = [
            'records' => [
                [
                    'form_id' => 1,
                    'id' => 100,
                    'purchase_id' => 'P123',
                    'purchase_item_id' => 10,
                    'product_id' => 12345,
                    'form_no' => 1,
                    'form_count' => 1,
                    'data' => ['field1' => 'value1'],
                    'address' => ['city' => 'Berlin'],
                ],
            ],
        ];
        $response = ListCustomFormRecordsResponse::fromArray($data);

        $this->assertInstanceOf(ListCustomFormRecordsResponse::class, $response);
        $this->assertCount(1, $response->records);

        $record = $response->records[0];
        $this->assertSame(1, $record->formId);
        $this->assertSame(100, $record->id);
        $this->assertSame('P123', $record->purchaseId);
        $this->assertSame(10, $record->purchaseItemId);
        $this->assertSame(12345, $record->productId);
        $this->assertSame(1, $record->formNo);
        $this->assertSame(1, $record->formCount);
        $this->assertSame(['field1' => 'value1'], $record->data);
        $this->assertSame(['city' => 'Berlin'], $record->address);
    }

    public function test_get_records_by_purchase_id(): void
    {
        $data = [
            'records' => [
                ['id' => 1, 'purchase_id' => 'P1'],
                ['id' => 2, 'purchase_id' => 'P2'],
                ['id' => 3, 'purchase_id' => 'P1'],
            ],
        ];
        $response = ListCustomFormRecordsResponse::fromArray($data);

        $filtered = $response->getRecordsByPurchaseId('P1');
        $this->assertCount(2, $filtered);
        $this->assertSame(1, $filtered[0]->id);
        $this->assertSame(3, $filtered[1]->id);
    }

    public function test_can_create_from_response(): void
    {
        $httpResponse = new Response(
            statusCode: 200,
            data: [
                'records' => [
                    [
                        'form_id' => 1,
                        'id' => 100,
                        'purchase_id' => 'P123',
                        'purchase_item_id' => 10,
                        'product_id' => 12345,
                        'form_no' => 1,
                        'form_count' => 1,
                    ],
                ],
            ],
            headers: [],
            rawBody: '',
        );

        $response = ListCustomFormRecordsResponse::fromResponse($httpResponse);

        $this->assertInstanceOf(ListCustomFormRecordsResponse::class, $response);
        $this->assertCount(1, $response->records);
        $this->assertSame(100, $response->records[0]->id);
    }

    public function test_has_raw_response(): void
    {
        $httpResponse = new Response(
            statusCode: 200,
            data: [],
            headers: [],
            rawBody: 'test',
        );

        $response = ListCustomFormRecordsResponse::fromResponse($httpResponse);

        $this->assertInstanceOf(Response::class, $response->rawResponse);
    }
}
