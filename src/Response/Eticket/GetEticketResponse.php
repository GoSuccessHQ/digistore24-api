<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\Eticket;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\Http\Response;

/**
 * Get E-Ticket Response
 *
 * Response containing the e-ticket record. The API wraps the record under an
 * `eticket` key. The full record is available via {@see self::$data} and as a
 * structured {@see EticketDetail} via {@see self::$eticket}.
 *
 * @link https://digistore24.com/api/docs/paths/getEticket.yaml
 */
final class GetEticketResponse extends AbstractResponse
{
    public string $result = '';

    /** Structured e-ticket record */
    public EticketDetail $eticket;

    /**
     * The complete e-ticket payload as returned by the API.
     *
     * @var array<string, mixed>
     */
    public array $data = [];

    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        // Record is wrapped under `eticket`; support a flat payload too.
        $eticket = $data['eticket'] ?? $data;
        if (! is_array($eticket)) {
            $eticket = [];
        }
        /** @var array<string, mixed> $eticketData */
        $eticketData = $eticket;

        $response = new self();
        $response->result = self::extractResult(data: $data, rawResponse: $rawResponse);
        $response->eticket = EticketDetail::fromArray($eticketData);
        $response->data = $eticketData;
        if ($rawResponse !== null) {
            $response->rawResponse = $rawResponse;
        }

        return $response;
    }
}
