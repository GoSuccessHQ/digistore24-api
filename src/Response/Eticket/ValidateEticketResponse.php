<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\Eticket;

use DateTimeInterface;
use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\Http\Response;
use GoSuccess\Digistore24\Api\Util\TypeConverter;

/**
 * Validate E-Ticket Response
 *
 * Response after validating an e-ticket against a template/location and date.
 *
 * @link https://digistore24.com/api/docs/paths/validateEticket.yaml
 */
final class ValidateEticketResponse extends AbstractResponse
{
    public string $result = '';

    /** Validation status: "success" or "error" */
    public string $status = '';

    /** Human-readable status message */
    public string $msg = '';

    /** The e-ticket's associated location ID */
    public int $eticketLocationId = 0;

    /** The e-ticket's associated template ID */
    public int $eticketTemplateId = 0;

    /** The e-ticket's date */
    public ?DateTimeInterface $eticketDate = null;

    /** Whether the e-ticket is valid for a different event */
    public bool $isEticketValidForDifferentEvent = false;

    /** Number of valid tickets matching the criteria */
    public int $validTicketCount = 0;

    /** Number of used tickets matching the criteria */
    public int $usedTicketCount = 0;

    /**
     * The complete validation payload as returned by the API.
     *
     * @var array<string, mixed>
     */
    public array $data = [];

    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        $inner = self::extractInnerData(data: $data);

        $response = new self();
        $response->result = self::extractResult(data: $data, rawResponse: $rawResponse);
        $response->status = TypeConverter::toString($inner['status'] ?? null, '') ?? '';
        $response->msg = TypeConverter::toString($inner['msg'] ?? null, '') ?? '';
        $response->eticketLocationId = TypeConverter::toInt($inner['eticket_location_id'] ?? null, 0) ?? 0;
        $response->eticketTemplateId = TypeConverter::toInt($inner['eticket_template_id'] ?? null, 0) ?? 0;
        $response->eticketDate = TypeConverter::toDateTime($inner['eticket_date'] ?? null);
        $response->isEticketValidForDifferentEvent = TypeConverter::toBool($inner['is_eticket_valid_for_different_event'] ?? null, false) ?? false;
        $response->validTicketCount = TypeConverter::toInt($inner['valid_ticket_count'] ?? null, 0) ?? 0;
        $response->usedTicketCount = TypeConverter::toInt($inner['used_ticket_count'] ?? null, 0) ?? 0;
        $response->data = $inner;
        if ($rawResponse !== null) {
            $response->rawResponse = $rawResponse;
        }

        return $response;
    }
}
