<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Tests\Unit\DataTransferObject;

use GoSuccess\Digistore24\Api\DTO\AddonData;
use PHPUnit\Framework\TestCase;

final class AddonDataTest extends TestCase
{
    public function testCanCreateWithRequiredFields(): void
    {
        $addon = AddonData::fromArray(['product_id' => 12345]);

        $this->assertSame(12345, $addon->productId);
        $this->assertNull($addon->amount);
        $this->assertSame(1, $addon->quantity);
        $this->assertFalse($addon->isQuantityEditableAfterPurchase);
    }

    public function testCanCreateWithAllFields(): void
    {
        $addon = AddonData::fromArray(['product_id' => 12345, 'amount' => 29.99, 'quantity' => 3, 'is_quantity_editable_after_purchase' => true]);

        $this->assertSame(12345, $addon->productId);
        $this->assertSame(29.99, $addon->amount);
        $this->assertSame(3, $addon->quantity);
        $this->assertTrue($addon->isQuantityEditableAfterPurchase);
    }

    public function testQuantityMustBeAtLeastOne(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Quantity must be at least 1');

        // Validation happens on direct assignment (user input), not when parsing an
        // API response via fromArray(), which intentionally trusts inbound data.
        $addon = new AddonData();
        $addon->quantity = 0;
    }

    public function testToArrayWithMinimalData(): void
    {
        $addon = AddonData::fromArray(['product_id' => 12345]);
        $array = $addon->toArray();

        $this->assertSame(12345, $array['product_id']);
        $this->assertSame(1, $array['quantity']);
        $this->assertSame('N', $array['is_quantity_editable_after_purchase']);
        $this->assertArrayNotHasKey('amount', $array);
    }

    public function testToArrayWithAllData(): void
    {
        $addon = AddonData::fromArray(['product_id' => 12345, 'amount' => 29.99, 'quantity' => 2, 'is_quantity_editable_after_purchase' => true]);
        $array = $addon->toArray();

        $this->assertSame(12345, $array['product_id']);
        $this->assertSame(29.99, $array['amount']);
        $this->assertSame(2, $array['quantity']);
        $this->assertSame('Y', $array['is_quantity_editable_after_purchase']);
    }

    public function testIsQuantityEditableConvertsToYN(): void
    {
        $addonYes = AddonData::fromArray(['product_id' => 12345, 'is_quantity_editable_after_purchase' => true]);
        $addonNo = AddonData::fromArray(['product_id' => 12345, 'is_quantity_editable_after_purchase' => false]);

        $this->assertSame('Y', $addonYes->toArray()['is_quantity_editable_after_purchase']);
        $this->assertSame('N', $addonNo->toArray()['is_quantity_editable_after_purchase']);
    }
}
