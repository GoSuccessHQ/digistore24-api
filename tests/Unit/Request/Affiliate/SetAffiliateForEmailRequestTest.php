<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Tests\Unit\Request\Affiliate;

use GoSuccess\Digistore24\Api\Request\Affiliate\SetAffiliateForEmailRequest;
use PHPUnit\Framework\TestCase;

final class SetAffiliateForEmailRequestTest extends TestCase
{
    public function test_can_create_instance(): void
    {
        $request = new SetAffiliateForEmailRequest(
            email: 'test@example.com',
            affiliate: 'AFF123',
        );

        $this->assertInstanceOf(SetAffiliateForEmailRequest::class, $request);
    }

    public function test_endpoint_returns_correct_value(): void
    {
        $request = new SetAffiliateForEmailRequest(
            email: 'test@example.com',
            affiliate: 'AFF123',
        );

        $this->assertSame('/setAffiliateForEmail', $request->getEndpoint());
    }

    public function test_to_array_returns_correct_data(): void
    {
        $request = new SetAffiliateForEmailRequest(
            email: 'test@example.com',
            affiliate: 'AFF123',
        );

        $array = $request->toArray();
        $this->assertSame('test@example.com', $array['email']);
        $this->assertSame('AFF123', $array['affiliate']);
        $this->assertArrayNotHasKey('campaignkey', $array);
        $this->assertArrayNotHasKey('trackingkey', $array);
        $this->assertArrayNotHasKey('click_id', $array);
    }

    public function test_to_array_includes_optional_parameters(): void
    {
        $request = new SetAffiliateForEmailRequest(
            email: 'test@example.com',
            affiliate: 'AFF123',
            campaignkey: 'campaign-1',
            trackingkey: 'tracking-1',
            clickId: 'click-1',
        );

        $array = $request->toArray();
        $this->assertSame('test@example.com', $array['email']);
        $this->assertSame('AFF123', $array['affiliate']);
        $this->assertSame('campaign-1', $array['campaignkey']);
        $this->assertSame('tracking-1', $array['trackingkey']);
        $this->assertSame('click-1', $array['click_id']);
    }

    public function test_validate_returns_empty_array(): void
    {
        $request = new SetAffiliateForEmailRequest(
            email: 'test@example.com',
            affiliate: 'AFF123',
        );

        $errors = $request->validate();
        $this->assertEmpty($errors);
    }
}
