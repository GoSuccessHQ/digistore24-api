<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\PaymentPlan;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\DTO\PaymentPlanListItemData;
use GoSuccess\Digistore24\Api\Http\Response;

/**
 * List Payment Plans Response
 *
 * Response containing the list of payment plans for a product. The spec returns
 * a bare JSON array; each item is exposed as a {@see PaymentPlanListItemData}.
 *
 * @link https://digistore24.com/api/docs/paths/listPaymentPlans.yaml
 */
final class ListPaymentPlansResponse extends AbstractResponse
{
    public string $result = '';

    /**
     * The payment plans as typed DTOs.
     *
     * @var array<int, PaymentPlanListItemData>
     */
    public array $paymentPlans = [];

    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        $innerData = self::extractInnerData(data: $data);

        // The spec returns a bare array; older payloads wrap the list under the
        // `payment_plans` key. Support both shapes.
        $plansData = $innerData['payment_plans'] ?? $innerData;
        if (! is_array($plansData)) {
            $plansData = [];
        }

        $plans = [];
        foreach ($plansData as $item) {
            if (! is_array($item)) {
                continue;
            }
            /** @var array<string, mixed> $validatedItem */
            $validatedItem = $item;
            $plans[] = PaymentPlanListItemData::fromArray($validatedItem);
        }

        $response = new self();
        $response->result = self::extractResult(data: $data, rawResponse: $rawResponse);
        $response->paymentPlans = $plans;

        if ($rawResponse !== null) {
            $response->rawResponse = $rawResponse;
        }

        return $response;
    }
}
