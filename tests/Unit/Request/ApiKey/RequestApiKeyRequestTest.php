<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Tests\Unit\Request\ApiKey;

use GoSuccess\Digistore24\Api\Enum\ApiPermissionLevel;
use GoSuccess\Digistore24\Api\Request\ApiKey\RequestApiKeyRequest;
use PHPUnit\Framework\TestCase;

final class RequestApiKeyRequestTest extends TestCase
{
    public function test_can_create_instance(): void
    {
        $request = new RequestApiKeyRequest(
            permissions: ApiPermissionLevel::READ_ONLY,
            returnUrl: 'https://example.com/return',
        );

        $this->assertInstanceOf(RequestApiKeyRequest::class, $request);
    }

    public function test_endpoint_returns_correct_value(): void
    {
        $request = new RequestApiKeyRequest(
            permissions: ApiPermissionLevel::READ_ONLY,
            returnUrl: 'https://example.com/return',
        );

        $this->assertSame('/requestApiKey', $request->getEndpoint());
    }

    public function test_to_array_includes_required_fields(): void
    {
        $request = new RequestApiKeyRequest(
            permissions: ApiPermissionLevel::WRITABLE,
            returnUrl: 'https://example.com/return',
        );

        $array = $request->toArray();
        $this->assertSame('writable', $array['permissions']);
        $this->assertSame('https://example.com/return', $array['return_url']);
        $this->assertArrayNotHasKey('cancel_url', $array);
        $this->assertArrayNotHasKey('site_url', $array);
        $this->assertArrayNotHasKey('comment', $array);
    }

    public function test_to_array_includes_optional_fields_when_set(): void
    {
        $request = new RequestApiKeyRequest(
            permissions: ApiPermissionLevel::READ_ONLY,
            returnUrl: 'https://example.com/return',
            cancelUrl: 'https://example.com/cancel',
            siteUrl: 'https://example.com',
            comment: 'My new API key',
        );

        $array = $request->toArray();
        $this->assertSame('read-only', $array['permissions']);
        $this->assertSame('https://example.com/return', $array['return_url']);
        $this->assertSame('https://example.com/cancel', $array['cancel_url']);
        $this->assertSame('https://example.com', $array['site_url']);
        $this->assertSame('My new API key', $array['comment']);
    }

    public function test_validate_returns_empty_array(): void
    {
        $request = new RequestApiKeyRequest(
            permissions: ApiPermissionLevel::READ_ONLY,
            returnUrl: 'https://example.com/return',
        );

        $errors = $request->validate();
        $this->assertEmpty($errors);
    }
}
