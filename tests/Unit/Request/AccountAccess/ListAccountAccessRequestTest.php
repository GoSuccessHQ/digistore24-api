<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Tests\Unit\Request\AccountAccess;

use GoSuccess\Digistore24\Api\Request\AccountAccess\ListAccountAccessRequest;
use PHPUnit\Framework\TestCase;

final class ListAccountAccessRequestTest extends TestCase
{
    public function test_can_create_instance(): void
    {
        $request = new ListAccountAccessRequest();

        $this->assertInstanceOf(ListAccountAccessRequest::class, $request);
    }

    public function test_endpoint_returns_correct_value(): void
    {
        $request = new ListAccountAccessRequest();

        $this->assertSame('/listAccountAccess', $request->getEndpoint());
    }

    public function test_to_array_returns_empty_array(): void
    {
        $request = new ListAccountAccessRequest();

        $array = $request->toArray();
        $this->assertEmpty($array);
    }

    public function test_validation_passes_for_valid_data(): void
    {
        $request = new ListAccountAccessRequest();

        $errors = $request->validate();
        $this->assertEmpty($errors);
    }
}
