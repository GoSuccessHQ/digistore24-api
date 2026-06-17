<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\Eticket;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\Http\Response;

/**
 * List E-Tickets Response
 *
 * Response containing the matching e-tickets under the `etickets` key.
 *
 * @link https://digistore24.com/api/docs/paths/listEtickets.yaml
 */
final class ListEticketsResponse extends AbstractResponse
{
    public string $result = '';

    /** @var array<int, EticketListItem> Array of e-ticket list items */
    public array $etickets = [];

    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        $innerData = self::extractInnerData(data: $data);
        $etickets = [];

        $eticketsData = $innerData['etickets'] ?? [];

        if (is_array($eticketsData)) {
            foreach ($eticketsData as $eticket) {
                if (! is_array($eticket)) {
                    continue;
                }
                /** @var array<string, mixed> $validatedEticket */
                $validatedEticket = $eticket;
                $etickets[] = EticketListItem::fromArray($validatedEticket);
            }
        }

        $response = new self();
        $response->result = self::extractResult(data: $data, rawResponse: $rawResponse);
        $response->etickets = $etickets;
        if ($rawResponse !== null) {
            $response->rawResponse = $rawResponse;
        }

        return $response;
    }
}
