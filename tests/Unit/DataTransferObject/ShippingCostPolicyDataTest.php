<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Tests\Unit\DataTransferObject;

use GoSuccess\Digistore24\Api\DTO\ShippingCostPolicyData;
use PHPUnit\Framework\TestCase;

final class ShippingCostPolicyDataTest extends TestCase
{
    public function test_to_array_emits_language_suffixed_labels(): void
    {
        $policy = new ShippingCostPolicyData();
        $policy->name = 'Standard';
        $policy->labels = ['en' => 'Shipping', 'de' => 'Versand'];

        $array = $policy->toArray();

        $this->assertSame('Shipping', $array['label_en']);
        $this->assertSame('Versand', $array['label_de']);
        $this->assertArrayNotHasKey('label_XX', $array);
    }

    public function test_label_length_is_validated(): void
    {
        $policy = new ShippingCostPolicyData();

        $this->expectException(\InvalidArgumentException::class);
        $policy->labels = ['en' => str_repeat('x', 64)];
    }
}
