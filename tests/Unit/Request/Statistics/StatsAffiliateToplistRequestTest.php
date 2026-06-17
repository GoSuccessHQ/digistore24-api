<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Tests\Unit\Request\Statistics;

use GoSuccess\Digistore24\Api\Request\Statistics\StatsAffiliateToplistRequest;
use PHPUnit\Framework\TestCase;

final class StatsAffiliateToplistRequestTest extends TestCase
{
    public function test_can_create_instance(): void
    {
        $request = new StatsAffiliateToplistRequest();

        $this->assertInstanceOf(StatsAffiliateToplistRequest::class, $request);
    }

    public function test_endpoint_returns_correct_value(): void
    {
        $request = new StatsAffiliateToplistRequest();

        $this->assertSame('/statsAffiliateToplist', $request->getEndpoint());
    }

    public function test_to_array_with_parameters(): void
    {
        $request = new StatsAffiliateToplistRequest(
            from: '2024-01',
            to: '2024-12',
            affiliate: 'john_doe',
            currency: 'EUR',
        );

        $array = $request->toArray();
        $this->assertSame('2024-01', $array['from']);
        $this->assertSame('2024-12', $array['to']);
        $this->assertSame('john_doe', $array['affiliate']);
        $this->assertSame('EUR', $array['currency']);
    }

    public function test_validate_returns_empty_array(): void
    {
        $request = new StatsAffiliateToplistRequest();

        $errors = $request->validate();
        $this->assertEmpty($errors);
    }
}
