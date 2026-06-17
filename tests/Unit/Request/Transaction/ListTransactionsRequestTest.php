<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Tests\Unit\Request\Transaction;

use GoSuccess\Digistore24\Api\DTO\TransactionSearchData;
use GoSuccess\Digistore24\Api\Enum\SortOrder;
use GoSuccess\Digistore24\Api\Enum\TransactionSortBy;
use GoSuccess\Digistore24\Api\Request\Transaction\ListTransactionsRequest;
use PHPUnit\Framework\TestCase;

final class ListTransactionsRequestTest extends TestCase
{
    public function test_can_create_instance(): void
    {
        $request = new ListTransactionsRequest();

        $this->assertInstanceOf(ListTransactionsRequest::class, $request);
    }

    public function test_endpoint_returns_correct_value(): void
    {
        $request = new ListTransactionsRequest();

        $this->assertSame('/listTransactions', $request->getEndpoint());
    }

    public function test_to_array_with_defaults(): void
    {
        $request = new ListTransactionsRequest();

        $array = $request->toArray();
        $this->assertSame('-24h', $array['from']);
        $this->assertSame('now', $array['to']);
        $this->assertSame('date', $array['sort_by']);
        $this->assertSame('asc', $array['sort_order']);
        $this->assertSame(1, $array['page_no']);
        $this->assertSame(500, $array['page_size']);
    }

    public function test_to_array_with_custom_parameters(): void
    {
        $search = new TransactionSearchData(
            email: 'test@example.com',
            productId: '12345',
            hasAffiliate: true,
        );

        $request = new ListTransactionsRequest(
            from: '2024-01-01',
            to: '2024-12-31',
            search: $search,
            sortBy: TransactionSortBy::EARNING,
            sortOrder: SortOrder::DESC,
            pageNo: 2,
            pageSize: 50,
        );

        $array = $request->toArray();
        $this->assertSame('2024-01-01', $array['from']);
        $this->assertSame('2024-12-31', $array['to']);
        $this->assertArrayHasKey('search', $array);
        $this->assertIsArray($array['search']);
        $this->assertSame('test@example.com', $array['search']['email']);
        $this->assertSame('12345', $array['search']['product_id']);
        $this->assertSame('Y', $array['search']['has_affiliate']);
        $this->assertSame('earning', $array['sort_by']);
        $this->assertSame('desc', $array['sort_order']);
        $this->assertSame(2, $array['page_no']);
        $this->assertSame(50, $array['page_size']);
    }

    public function test_validate_returns_empty_array(): void
    {
        $request = new ListTransactionsRequest();

        $errors = $request->validate();
        $this->assertEmpty($errors);
    }
}
