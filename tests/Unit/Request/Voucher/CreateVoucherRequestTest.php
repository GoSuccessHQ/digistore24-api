<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Tests\Unit\Request\Voucher;

use GoSuccess\Digistore24\Api\DTO\VoucherData;
use GoSuccess\Digistore24\Api\Request\Voucher\CreateVoucherRequest;
use PHPUnit\Framework\TestCase;

final class CreateVoucherRequestTest extends TestCase
{
    public function test_can_create_instance(): void
    {
        $voucher = new VoucherData();
        $voucher->code = 'SAVE20';
        $voucher->firstRate = 20.0;

        $request = new CreateVoucherRequest(voucher: $voucher);

        $this->assertInstanceOf(CreateVoucherRequest::class, $request);
    }

    public function test_endpoint_returns_correct_value(): void
    {
        $voucher = new VoucherData();
        $voucher->code = 'SAVE20';
        $voucher->firstRate = 20.0;

        $request = new CreateVoucherRequest(voucher: $voucher);

        $this->assertSame('/createVoucher', $request->getEndpoint());
    }

    public function test_to_array_includes_data(): void
    {
        $voucher = new VoucherData();
        $voucher->code = 'SAVE20';
        $voucher->firstRate = 20.0;

        $request = new CreateVoucherRequest(voucher: $voucher);

        $array = $request->toArray();
        $data = $array['data'];
        $this->assertIsArray($data);
        $this->assertSame('SAVE20', $data['code']);
        $this->assertSame(20.0, $data['first_rate']);
    }

    public function test_validate_returns_empty_array(): void
    {
        $voucher = new VoucherData();
        $voucher->code = 'SAVE20';
        $voucher->firstRate = 20.0;

        $request = new CreateVoucherRequest(voucher: $voucher);

        $errors = $request->validate();
        $this->assertEmpty($errors);
    }
}
