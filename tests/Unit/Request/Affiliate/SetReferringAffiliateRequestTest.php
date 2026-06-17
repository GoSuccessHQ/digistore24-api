<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Tests\Unit\Request\Affiliate;

use GoSuccess\Digistore24\Api\Request\Affiliate\SetReferringAffiliateRequest;
use PHPUnit\Framework\TestCase;

final class SetReferringAffiliateRequestTest extends TestCase
{
    public function test_can_create_instance(): void
    {
        $request = new SetReferringAffiliateRequest(
            referrerId: 'REF123',
            affiliateId: 'AFF123',
        );

        $this->assertInstanceOf(SetReferringAffiliateRequest::class, $request);
    }

    public function test_endpoint_returns_correct_value(): void
    {
        $request = new SetReferringAffiliateRequest(
            referrerId: 'REF123',
            affiliateId: 'AFF123',
        );

        $this->assertSame('/setReferringAffiliate', $request->getEndpoint());
    }

    public function test_to_array_returns_correct_data(): void
    {
        $request = new SetReferringAffiliateRequest(
            referrerId: 'REF123',
            affiliateId: 'AFF123',
        );

        $array = $request->toArray();
        $this->assertSame('REF123', $array['referrer_id']);
        $this->assertSame('AFF123', $array['affiliate_id']);
        $this->assertArrayNotHasKey('commission', $array);
    }

    public function test_to_array_includes_commission(): void
    {
        $request = new SetReferringAffiliateRequest(
            referrerId: 'REF123',
            affiliateId: 'AFF123',
            commission: 25.5,
        );

        $array = $request->toArray();
        $this->assertSame('REF123', $array['referrer_id']);
        $this->assertSame('AFF123', $array['affiliate_id']);
        $this->assertSame(25.5, $array['commission']);
    }

    public function test_validate_returns_empty_array(): void
    {
        $request = new SetReferringAffiliateRequest(
            referrerId: 'REF123',
            affiliateId: 'AFF123',
        );

        $errors = $request->validate();
        $this->assertEmpty($errors);
    }
}
