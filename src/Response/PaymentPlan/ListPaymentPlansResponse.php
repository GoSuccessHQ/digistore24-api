<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\PaymentPlan;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\Http\Response;

/**
 * List Payment Plans Response
 *
 * Response object for the PaymentPlan API endpoint.
 */
final class ListPaymentPlansResponse extends AbstractResponse
{
    public string $result = '';

    /**
     * @var array<string, mixed>
     */
    public array $paymentPlans = [];

    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        $innerData = self::extractInnerData(data: $data);
        $paymentPlans = $innerData['payment_plans'] ?? [];

        if (! is_array($paymentPlans)) {
            $paymentPlans = [];
        }

        /** @var array<string, mixed> $validatedPlans */
        $validatedPlans = $paymentPlans;

        $response = new self();
        $response->result = self::extractResult(data: $data, rawResponse: $rawResponse);
        $response->paymentPlans = $validatedPlans;

        if ($rawResponse !== null) {
            $response->rawResponse = $rawResponse;
        }

        return $response;
    }
}
