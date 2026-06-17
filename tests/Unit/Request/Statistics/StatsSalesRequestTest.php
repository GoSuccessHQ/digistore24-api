<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Tests\Unit\Request\Statistics;

use GoSuccess\Digistore24\Api\Enum\StatsPeriod;
use GoSuccess\Digistore24\Api\Request\Statistics\StatsSalesRequest;
use PHPUnit\Framework\TestCase;

final class StatsSalesRequestTest extends TestCase
{
    public function test_can_create_instance(): void
    {
        $request = new StatsSalesRequest();

        $this->assertInstanceOf(StatsSalesRequest::class, $request);
    }

    public function test_endpoint_returns_correct_value(): void
    {
        $request = new StatsSalesRequest();

        $this->assertSame('/statsSales', $request->getEndpoint());
    }

    public function test_to_array_with_date_range(): void
    {
        $request = new StatsSalesRequest(from: '2024-01-01', to: '2024-12-31');

        $array = $request->toArray();
        $this->assertSame('2024-01-01', $array['from']);
        $this->assertSame('2024-12-31', $array['to']);
        $this->assertArrayNotHasKey('period', $array);
    }

    public function test_to_array_includes_period_when_set(): void
    {
        $request = new StatsSalesRequest(
            from: '2024-01-01',
            to: '2024-12-31',
            period: StatsPeriod::MONTH,
        );

        $array = $request->toArray();
        $this->assertSame('month', $array['period']);
    }

    public function test_validate_returns_empty_array(): void
    {
        $request = new StatsSalesRequest();

        $errors = $request->validate();
        $this->assertEmpty($errors);
    }
}
