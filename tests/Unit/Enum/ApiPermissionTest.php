<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Tests\Unit\Enum;

use GoSuccess\Digistore24\Api\Enum\ApiPermission;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ApiPermission::class)]
final class ApiPermissionTest extends TestCase
{
    public function testAllCasesHaveCorrectValues(): void
    {
        $this->assertSame('readonly', ApiPermission::READONLY->value);
        $this->assertSame('delivery', ApiPermission::DELIVERY->value);
        $this->assertSame('writable', ApiPermission::WRITABLE->value);
    }

    public function testAllCasesHaveLabels(): void
    {
        $this->assertSame('Read Only', ApiPermission::READONLY->label());
        $this->assertSame('Delivery', ApiPermission::DELIVERY->label());
        $this->assertSame('Writable', ApiPermission::WRITABLE->label());
    }

    public function testFromString(): void
    {
        $this->assertSame(ApiPermission::READONLY, ApiPermission::fromString('readonly'));
        $this->assertSame(ApiPermission::DELIVERY, ApiPermission::fromString('delivery'));
        $this->assertSame(ApiPermission::WRITABLE, ApiPermission::fromString('writable'));
    }

    public function testFromStringCaseInsensitive(): void
    {
        $this->assertSame(ApiPermission::READONLY, ApiPermission::fromString('READONLY'));
        $this->assertSame(ApiPermission::DELIVERY, ApiPermission::fromString('DeliVery'));
        $this->assertSame(ApiPermission::WRITABLE, ApiPermission::fromString('WRITABLE'));
    }

    public function testFromStringWithInvalidValue(): void
    {
        $this->assertNull(ApiPermission::fromString('invalid'));
        $this->assertNull(ApiPermission::fromString(''));
        $this->assertNull(ApiPermission::fromString(null));
    }

    public function testLabels(): void
    {
        $expected = [
            'readonly' => 'Read Only',
            'delivery' => 'Delivery',
            'writable' => 'Writable',
        ];

        $this->assertSame($expected, ApiPermission::labels());
    }

    public function testValues(): void
    {
        $expected = ['readonly', 'delivery', 'writable'];
        $this->assertSame($expected, ApiPermission::values());
    }

    public function testIsValid(): void
    {
        $this->assertTrue(ApiPermission::isValid('readonly'));
        $this->assertTrue(ApiPermission::isValid('delivery'));
        $this->assertTrue(ApiPermission::isValid('writable'));
        $this->assertTrue(ApiPermission::isValid('READONLY')); // case-insensitive
        $this->assertFalse(ApiPermission::isValid('invalid'));
        $this->assertFalse(ApiPermission::isValid(null));
    }
}
