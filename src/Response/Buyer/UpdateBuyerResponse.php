<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\Buyer;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\Http\Response;
use GoSuccess\Digistore24\Api\Util\TypeConverter;

/**
 * Update Buyer Response
 *
 * Response for updating buyer contact details.
 */
final class UpdateBuyerResponse extends AbstractResponse
{
    /**
     * Request result status
     */
    public string $result = '';

    /**
     * Buyer ID
     */
    public ?int $buyerId = null;

    /**
     * Email address
     */
    public string $email = '';

    /**
     * First name
     */
    public ?string $firstName = null;

    /**
     * Last name
     */
    public ?string $lastName = null;

    /**
     * Company name
     */
    public ?string $company = null;

    /**
     * Updated timestamp
     */
    public ?\DateTimeInterface $updatedAt = null;

    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        $innerData = self::extractInnerData(data: $data);

        $response = new self();
        $response->result = self::extractResult(data: $data, rawResponse: $rawResponse);
        $response->buyerId = TypeConverter::toInt($innerData['buyer_id'] ?? null);
        $response->email = is_string($innerData['email'] ?? null) ? $innerData['email'] : '';
        $response->firstName = is_string($innerData['first_name'] ?? null) ? $innerData['first_name'] : null;
        $response->lastName = is_string($innerData['last_name'] ?? null) ? $innerData['last_name'] : null;
        $response->company = is_string($innerData['company'] ?? null) ? $innerData['company'] : null;
        $response->updatedAt = TypeConverter::toDateTime($innerData['updated_at'] ?? null);

        if ($rawResponse !== null) {
            $response->rawResponse = $rawResponse;
        }

        return $response;
    }
}
