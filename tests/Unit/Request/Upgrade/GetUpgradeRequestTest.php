<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Tests\Unit\Request\Upgrade;

use GoSuccess\Digistore24\Api\Request\Upgrade\GetUpgradeRequest;
use PHPUnit\Framework\TestCase;

final class GetUpgradeRequestTest extends TestCase
{
    public function test_can_create_instance(): void
    {
        $request = new GetUpgradeRequest(upgradeId: 'UPG123');

        $this->assertInstanceOf(GetUpgradeRequest::class, $request);
    }

    public function test_endpoint_returns_correct_value(): void
    {
        $request = new GetUpgradeRequest(upgradeId: 'UPG123');

        $this->assertSame('/getUpgrade', $request->getEndpoint());
    }

    public function test_to_array_includes_upgrade_id(): void
    {
        $request = new GetUpgradeRequest(upgradeId: 'UPG123');

        $array = $request->toArray();
        $this->assertSame('UPG123', $array['upgrade_id']);
        $this->assertArrayNotHasKey('order_ids', $array);
    }

    public function test_to_array_includes_order_ids_when_set(): void
    {
        $request = new GetUpgradeRequest(upgradeId: 'UPG123', orderIds: 'A1,B2');

        $array = $request->toArray();
        $this->assertSame('UPG123', $array['upgrade_id']);
        $this->assertSame('A1,B2', $array['order_ids']);
    }

    public function test_validate_returns_empty_array(): void
    {
        $request = new GetUpgradeRequest(upgradeId: 'UPG123');

        $errors = $request->validate();
        $this->assertEmpty($errors);
    }
}
