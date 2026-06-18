<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Tests\Unit\Request\Voucher;

use GoSuccess\Digistore24\Api\DTO\VoucherData;
use GoSuccess\Digistore24\Api\Request\Voucher\UpdateVoucherRequest;
use PHPUnit\Framework\TestCase;

final class UpdateVoucherRequestTest extends TestCase
{
    public function test_can_create_instance(): void
    {
        $voucher = new VoucherData();
        $voucher->firstRate = 25.0;

        $request = new UpdateVoucherRequest(code: 'SAVE20', voucher: $voucher);

        $this->assertInstanceOf(UpdateVoucherRequest::class, $request);
    }

    public function test_endpoint_returns_correct_value(): void
    {
        $voucher = new VoucherData();
        $voucher->firstRate = 25.0;

        $request = new UpdateVoucherRequest(code: 'SAVE20', voucher: $voucher);

        $this->assertSame('/updateVoucher', $request->getEndpoint());
    }

    public function test_to_array_includes_code_and_data(): void
    {
        $voucher = new VoucherData();
        $voucher->code = 'SAVE20';
        $voucher->firstRate = 25.0;

        $request = new UpdateVoucherRequest(code: 'SAVE20', voucher: $voucher);

        $array = $request->toArray();
        $this->assertSame('SAVE20', $array['code']);
        $data = $array['data'];
        $this->assertIsArray($data);
        $this->assertSame(25.0, $data['first_rate']);
    }

    public function test_validate_returns_empty_array(): void
    {
        $voucher = new VoucherData();
        $voucher->firstRate = 25.0;

        $request = new UpdateVoucherRequest(code: 'SAVE20', voucher: $voucher);

        $errors = $request->validate();
        $this->assertEmpty($errors);
    }
}
