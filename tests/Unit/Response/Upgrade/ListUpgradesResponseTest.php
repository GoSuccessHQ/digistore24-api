<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Tests\Unit\Response\Upgrade;

use GoSuccess\Digistore24\Api\DTO\UpgradeItemData;
use GoSuccess\Digistore24\Api\Http\Response;
use GoSuccess\Digistore24\Api\Response\Upgrade\ListUpgradesResponse;
use PHPUnit\Framework\TestCase;

final class ListUpgradesResponseTest extends TestCase
{
    public function test_can_create_from_array(): void
    {
        $data = [
            'data' => [
                'upgrades' => [
                    [
                        'id' => 1,
                        'name' => 'Upgrade A',
                        'to_product_id' => 200,
                        'is_active' => 'Y',
                        'upgrade_types' => ['100' => 'upgrade'],
                    ],
                    [
                        'id' => 2,
                        'name' => 'Upgrade B',
                        'to_product_id' => 300,
                        'is_active' => 'N',
                        'upgrade_types' => ['200' => 'downgrade'],
                    ],
                ],
            ],
        ];
        $response = ListUpgradesResponse::fromArray($data);

        $this->assertInstanceOf(ListUpgradesResponse::class, $response);
        $upgrades = $response->upgrades;
        $this->assertCount(2, $upgrades);
        $this->assertInstanceOf(UpgradeItemData::class, $upgrades[0]);
        $this->assertSame(1, $upgrades[0]->id);
        $this->assertSame('Upgrade A', $upgrades[0]->name);
        $this->assertSame(200, $upgrades[0]->toProductId);
        $this->assertTrue($upgrades[0]->isActive);
        $this->assertFalse($upgrades[1]->isActive);
    }

    public function test_can_create_from_response(): void
    {
        $httpResponse = new Response(
            statusCode: 200,
            data: [
                'data' => [
                    'upgrades' => [
                        ['id' => 999, 'name' => 'Upgrade'],
                    ],
                ],
            ],
            headers: [],
            rawBody: '',
        );

        $response = ListUpgradesResponse::fromResponse($httpResponse);

        $this->assertInstanceOf(ListUpgradesResponse::class, $response);
        $this->assertCount(1, $response->upgrades);
        $this->assertSame(999, $response->upgrades[0]->id);
    }

    public function test_has_raw_response(): void
    {
        $httpResponse = new Response(
            statusCode: 200,
            data: [
                'data' => [
                    'upgrades' => [],
                ],
            ],
            headers: [],
            rawBody: 'test',
        );

        $response = ListUpgradesResponse::fromResponse($httpResponse);

        $this->assertInstanceOf(Response::class, $response->rawResponse);
    }
}
