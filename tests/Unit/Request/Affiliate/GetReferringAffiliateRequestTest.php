<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Tests\Unit\Request\Affiliate;

use GoSuccess\Digistore24\Api\Enum\HttpMethod;
use GoSuccess\Digistore24\Api\Request\Affiliate\GetReferringAffiliateRequest;
use PHPUnit\Framework\TestCase;

final class GetReferringAffiliateRequestTest extends TestCase
{
    public function test_can_create_instance_with_affiliate_id(): void
    {
        $request = new GetReferringAffiliateRequest(affiliateId: 'AFF123');

        $this->assertInstanceOf(GetReferringAffiliateRequest::class, $request);
    }

    public function test_endpoint_returns_correct_value(): void
    {
        $request = new GetReferringAffiliateRequest(affiliateId: 'AFF123');

        $this->assertSame('/getReferringAffiliate', $request->getEndpoint());
    }

    public function test_method_returns_get(): void
    {
        $request = new GetReferringAffiliateRequest(affiliateId: 'AFF123');

        $this->assertSame(HttpMethod::GET, $request->getMethod());
    }

    public function test_to_array_returns_correct_data(): void
    {
        $request = new GetReferringAffiliateRequest(affiliateId: 'AFF123');

        $array = $request->toArray();
        $this->assertSame('AFF123', $array['affiliate_id']);
    }

    public function test_validate_returns_empty_array(): void
    {
        $request = new GetReferringAffiliateRequest(affiliateId: 'AFF123');

        $errors = $request->validate();
        $this->assertEmpty($errors);
    }
}
