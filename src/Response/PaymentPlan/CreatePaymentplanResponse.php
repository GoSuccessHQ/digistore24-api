<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\PaymentPlan;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\Http\Response;

/**
 * Create Paymentplan Response
 *
 * Response object for the PaymentPlan API endpoint.
 */
final class CreatePaymentplanResponse extends AbstractResponse
{
    public string $result = '';

    /**
     * @var array<string, mixed>
     */
    public array $data = [];

    public function getPaymentplanId(): ?string
    {
        $id = $this->data['paymentplan_id'] ?? null;

        return is_string($id) ? $id : null;
    }

    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        $innerData = self::extractInnerData(data: $data);

        /** @var array<string, mixed> $validatedData */
        $validatedData = $innerData;

        $response = new self();
        $response->result = self::extractResult(data: $data, rawResponse: $rawResponse);
        $response->data = $validatedData;

        if ($rawResponse !== null) {
            $response->rawResponse = $rawResponse;
        }

        return $response;
    }
}
