<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\AccountAccess;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\DTO\AccountAccessData;
use GoSuccess\Digistore24\Api\Http\Response;

/**
 * List Account Access Response
 *
 * Response containing account access permissions granted by and to the API key owner.
 */
final class ListAccountAccessResponse extends AbstractResponse
{
    /**
     * Result status
     */
    public string $result = '';

    /**
     * Accounts you have granted access to
     *
     * @var AccountAccessData[]
     */
    public array $byMe = [];

    /**
     * Accounts you have been granted access to
     *
     * @var AccountAccessData[]
     */
    public array $toMe = [];

    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        $innerData = self::extractInnerData(data: $data);

        $response = new self();
        $response->result = self::extractResult(data: $data, rawResponse: $rawResponse);

        $byMe = [];
        $byMeData = $innerData['by_me'] ?? [];
        if (is_array($byMeData)) {
            foreach ($byMeData as $entry) {
                if (is_array($entry)) {
                    /** @var array<string, mixed> $validatedEntry */
                    $validatedEntry = $entry;
                    $byMe[] = AccountAccessData::fromArray($validatedEntry);
                }
            }
        }
        $response->byMe = $byMe;

        $toMe = [];
        $toMeData = $innerData['to_me'] ?? [];
        if (is_array($toMeData)) {
            foreach ($toMeData as $entry) {
                if (is_array($entry)) {
                    /** @var array<string, mixed> $validatedEntry */
                    $validatedEntry = $entry;
                    $toMe[] = AccountAccessData::fromArray($validatedEntry);
                }
            }
        }
        $response->toMe = $toMe;

        if ($rawResponse !== null) {
            $response->rawResponse = $rawResponse;
        }

        return $response;
    }
}
