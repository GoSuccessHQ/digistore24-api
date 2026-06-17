<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\PaymentPlan;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\DTO\PaymentPlanRenderedTextsData;
use GoSuccess\Digistore24\Api\Http\Response;
use GoSuccess\Digistore24\Api\Util\TypeConverter;

/**
 * Create Paymentplan Response
 *
 * Response containing the ID of the newly created payment plan, the rendered
 * order-form texts and the full payment plan object.
 *
 * @link https://digistore24.com/api/docs/paths/createPaymentplan.yaml
 */
final class CreatePaymentplanResponse extends AbstractResponse
{
    public string $result = '';

    /**
     * ID of the created payment plan (spec key: `paymentplan_id`).
     */
    public ?int $paymentplanId = null;

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
     * The complete response payload as returned by the API, so every field is
     * accessible even when not surfaced as a typed property above.
     *
     * @var array<string, mixed>
     */
    public array $data = [];

    /**
     * The created payment plan ID as a string for backward compatibility.
     */
    public function getPaymentplanId(): ?string
    {
        $id = $this->data['paymentplan_id'] ?? null;

        if (is_string($id)) {
            return $id;
        }

        return is_int($id) ? (string)$id : null;
    }

    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        $innerData = self::extractInnerData(data: $data);

        $renderedTexts = is_array($innerData['rendered_texts'] ?? null) ? $innerData['rendered_texts'] : null;
        $plan = is_array($innerData['plan'] ?? null) ? $innerData['plan'] : [];

        /** @var array<string, mixed> $validatedData */
        $validatedData = $innerData;
        /** @var array<string, mixed> $validatedPlan */
        $validatedPlan = $plan;

        $response = new self();
        $response->result = self::extractResult(data: $data, rawResponse: $rawResponse);
        $response->paymentplanId = TypeConverter::toInt($innerData['paymentplan_id'] ?? null);
        $response->renderedTexts = $renderedTexts !== null
            ? PaymentPlanRenderedTextsData::fromArray(self::toStringKeyedArray($renderedTexts))
            : null;
        $response->plan = $validatedPlan;
        $response->data = $validatedData;

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
