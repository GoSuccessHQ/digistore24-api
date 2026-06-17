<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Tests\Unit\DataTransferObject;

use GoSuccess\Digistore24\Api\DTO\VoucherData;
use PHPUnit\Framework\TestCase;

final class VoucherDataTest extends TestCase
{
    public function test_to_array_emits_spec_fields(): void
    {
        $voucher = new VoucherData();
        $voucher->code = 'SAVE20';
        $voucher->firstRate = 20.0;
        $voucher->expiresAt = '2024-12-31 23:59:59';
        $voucher->currency = 'EUR';

        $array = $voucher->toArray();

        $this->assertSame('SAVE20', $array['code']);
        $this->assertSame('all', $array['product_ids']);
        $this->assertSame(20.0, $array['first_rate']);
        $this->assertSame('2024-12-31 23:59:59', $array['expires_at']);
        $this->assertSame('EUR', $array['currency']);
        $this->assertSame('N', $array['is_count_limited']);
        $this->assertSame(1, $array['count_left']);
        $this->assertSame('valid', $array['upgrade_policy']);
    }

    public function test_to_array_excludes_response_only_id_and_valid_until_alias(): void
    {
        $voucher = VoucherData::fromArray([
            'code' => 'SAVE20',
            'id' => 12345,
            'valid_until' => '2024-12-31 23:59:59',
        ]);

        $array = $voucher->toArray();

        $this->assertArrayNotHasKey('id', $array);
        $this->assertArrayNotHasKey('valid_until', $array);
    }
}
