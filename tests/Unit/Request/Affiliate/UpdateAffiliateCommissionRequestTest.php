<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Tests\Unit\Request\Affiliate;

use GoSuccess\Digistore24\Api\DTO\AffiliateCommissionData;
use GoSuccess\Digistore24\Api\Enum\HttpMethod;
use GoSuccess\Digistore24\Api\Request\Affiliate\UpdateAffiliateCommissionRequest;
use PHPUnit\Framework\TestCase;

final class UpdateAffiliateCommissionRequestTest extends TestCase
{
    public function test_can_create_instance(): void
    {
        $commission = new AffiliateCommissionData();
        $commission->commissionRate = 10.5;

        $request = new UpdateAffiliateCommissionRequest(
            affiliateId: 'AFF123',
            productIds: '12345',
            commission: $commission,
        );

        $this->assertInstanceOf(UpdateAffiliateCommissionRequest::class, $request);
    }

    public function test_endpoint_returns_correct_value(): void
    {
        $commission = new AffiliateCommissionData();
        $commission->commissionRate = 10.5;

        $request = new UpdateAffiliateCommissionRequest(
            affiliateId: 'AFF123',
            productIds: '12345',
            commission: $commission,
        );

        $this->assertSame('/updateAffiliateCommission', $request->getEndpoint());
    }

    public function test_method_returns_put(): void
    {
        $commission = new AffiliateCommissionData();
        $commission->commissionRate = 10.5;

        $request = new UpdateAffiliateCommissionRequest(
            affiliateId: 'AFF123',
            productIds: 'all',
            commission: $commission,
        );

        $this->assertSame(HttpMethod::PUT, $request->getMethod());
    }

    public function test_to_array_includes_all_data(): void
    {
        $commission = new AffiliateCommissionData();
        $commission->commissionRate = 10.5;
        $commission->commissionFix = 5.0;

        $request = new UpdateAffiliateCommissionRequest(
            affiliateId: 'AFF123',
            productIds: '12345,67890',
            commission: $commission,
        );

        $array = $request->toArray();
        $this->assertSame('AFF123', $array['affiliate_id']);
        $this->assertSame('12345,67890', $array['product_ids']);
        $this->assertSame(10.5, $array['commission_rate']);
        $this->assertSame(5.0, $array['commission_fix']);
    }

    public function test_validate_returns_empty_array(): void
    {
        $commission = new AffiliateCommissionData();
        $commission->commissionRate = 10.5;

        $request = new UpdateAffiliateCommissionRequest(
            affiliateId: 'AFF123',
            productIds: 'all',
            commission: $commission,
        );

        $errors = $request->validate();
        $this->assertEmpty($errors);
    }
}
