<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Tests\Unit\Response\Purchase;

use GoSuccess\Digistore24\Api\DTO\UpgradeInfoData;
use GoSuccess\Digistore24\Api\DTO\UpgradeNewPurchaseData;
use GoSuccess\Digistore24\Api\Http\Response;
use GoSuccess\Digistore24\Api\Response\Purchase\CreateUpgradePurchaseResponse;
use PHPUnit\Framework\TestCase;

final class CreateUpgradePurchaseResponseTest extends TestCase
{
    public function test_can_create_from_array(): void
    {
        $data = [
            'data' => [
                'new_purchase' => [
                    'id' => 'P123456',
                    'billing_status' => 'paying',
                    'paid_amount' => 19.99,
                    'next_payment_at' => '2024-02-15',
                    'next_amount' => 29.99,
                    'currency' => 'EUR',
                ],
                'upgrade_info' => [
                    'upgrade_type' => 'upgrade',
                    'upgrade_amount_left' => 10.00,
                    'upgrade_amount_total' => 49.99,
                    'upgraded_purchase_id' => 'P111111',
                ],
            ],
        ];
        $response = CreateUpgradePurchaseResponse::fromArray($data);

        $this->assertInstanceOf(CreateUpgradePurchaseResponse::class, $response);

        // Typed new_purchase object.
        $this->assertInstanceOf(UpgradeNewPurchaseData::class, $response->newPurchase);
        $this->assertSame('P123456', $response->newPurchase->id);
        $this->assertSame('paying', $response->newPurchase->billingStatus);
        $this->assertSame(19.99, $response->newPurchase->paidAmount);
        $this->assertSame('2024-02-15', $response->newPurchase->nextPaymentAt);
        $this->assertSame(29.99, $response->newPurchase->nextAmount);
        $this->assertSame('EUR', $response->newPurchase->currency);

        // Typed upgrade_info object.
        $this->assertInstanceOf(UpgradeInfoData::class, $response->upgradeInfo);
        $this->assertSame('upgrade', $response->upgradeInfo->upgradeType);
        $this->assertSame(10.00, $response->upgradeInfo->upgradeAmountLeft);
        $this->assertSame(49.99, $response->upgradeInfo->upgradeAmountTotal);
        $this->assertSame('P111111', $response->upgradeInfo->upgradedPurchaseId);

        // Backward-compatible array accessors.
        $newPurchase = $response->getNewPurchase();
        $this->assertSame('P123456', $newPurchase['id'] ?? null);
        $upgradeInfo = $response->getUpgradeInfo();
        $this->assertSame('P111111', $upgradeInfo['upgraded_purchase_id'] ?? null);
    }

    public function test_can_create_from_response(): void
    {
        $httpResponse = new Response(
            statusCode: 200,
            data: [
                'data' => [
                    'data' => [
                        'new_purchase' => [
                            'id' => 'P654321',
                            'currency' => 'USD',
                        ],
                        'upgrade_info' => [
                            'upgrade_type' => 'downgrade',
                        ],
                    ],
                ],
            ],
            headers: [],
            rawBody: '',
        );

        $response = CreateUpgradePurchaseResponse::fromResponse($httpResponse);

        $this->assertInstanceOf(CreateUpgradePurchaseResponse::class, $response);
        $this->assertNotNull($response->newPurchase);
        $this->assertSame('P654321', $response->newPurchase->id);
        $this->assertNotNull($response->upgradeInfo);
        $this->assertSame('downgrade', $response->upgradeInfo->upgradeType);
    }

    public function test_has_raw_response(): void
    {
        $httpResponse = new Response(
            statusCode: 200,
            data: [
                'data' => [
                    'new_purchase' => ['id' => 'P999999'],
                ],
            ],
            headers: [],
            rawBody: 'test',
        );

        $response = CreateUpgradePurchaseResponse::fromResponse($httpResponse);

        $this->assertInstanceOf(Response::class, $response->rawResponse);
    }
}
