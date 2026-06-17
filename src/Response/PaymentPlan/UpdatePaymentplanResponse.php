<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\PaymentPlan;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\DTO\PaymentPlanRenderedTextsData;
use GoSuccess\Digistore24\Api\Http\Response;
use GoSuccess\Digistore24\Api\Util\TypeConverter;

/**
 * Update Paymentplan Response
 *
 * Response indicating whether the payment plan was modified, plus the rendered
 * order-form texts and the full payment plan object.
 *
 * @link https://digistore24.com/api/docs/paths/updatePaymentplan.yaml
 */
final class UpdatePaymentplanResponse extends AbstractResponse
{
    public string $result = '';

    /**
     * Whether changes were made (spec: `modified`, Y/N).
     */
    public ?bool $modified = null;

    /**
     * Rendered display texts for the order form.
     */
    public ?PaymentPlanRenderedTextsData $renderedTexts = null;

    /**
     * The complete payment plan object as returned by the API.
     *
     * @var array<string, mixed>
     */
    public array $plan = [];

    /**
     * The complete response payload as returned by the API.
     *
     * @var array<string, mixed>
     */
    public array $data = [];

    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        $innerData = self::extractInnerData(data: $data);

        $renderedTexts = is_array($innerData['rendered_texts'] ?? null) ? $innerData['rendered_texts'] : null;
        $plan = is_array($innerData['plan'] ?? null) ? $innerData['plan'] : [];

        /** @var array<string, mixed> $validatedPlan */
        $validatedPlan = $plan;

        $response = new self();
        $response->result = self::extractResult(data: $data, rawResponse: $rawResponse);
        $response->modified = TypeConverter::toBool($innerData['modified'] ?? null);
        $response->renderedTexts = $renderedTexts !== null
            ? PaymentPlanRenderedTextsData::fromArray(self::toStringKeyedArray($renderedTexts))
            : null;
        $response->plan = $validatedPlan;
        $response->data = $innerData;

        if ($rawResponse !== null) {
            $response->rawResponse = $rawResponse;
        }

        return $response;
    }

    /**
     * @param array<mixed, mixed> $value
     * @return array<string, mixed>
     */
    private static function toStringKeyedArray(array $value): array
    {
        $result = [];
        foreach ($value as $key => $item) {
            $result[(string)$key] = $item;
        }

        return $result;
    }
}
