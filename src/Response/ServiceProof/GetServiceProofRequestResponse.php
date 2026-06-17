<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\ServiceProof;

use DateTimeImmutable;
use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\DTO\ServiceProofRequestData;
use GoSuccess\Digistore24\Api\Http\Response;
use GoSuccess\Digistore24\Api\Util\TypeConverter;

/**
 * Get Service Proof Request Response
 *
 * Response containing the details of a single service proof request. Mirrors the
 * spec's `service_proof_request` object.
 *
 * @link https://digistore24.com/api/docs/paths/getServiceProofRequest.yaml
 */
final class GetServiceProofRequestResponse extends AbstractResponse
{
    public string $result = '';

    /** Service proof request ID */
    public ?int $id = null;

    /** Associated purchase ID */
    public ?string $purchaseId = null;

    /** Current status of the service proof request */
    public ?string $status = null;

    /** When the request was created */
    public ?DateTimeImmutable $createdAt = null;

    /** When the proof needs to be provided by */
    public ?DateTimeImmutable $dueDate = null;

    /** Additional notes about the request */
    public ?string $notes = null;

    /** The service proof request as a typed DTO */
    public ?ServiceProofRequestData $serviceProofRequest = null;

    /**
     * The complete service_proof_request payload as returned by the API, so every
     * field is accessible even when not surfaced as a typed property above.
     *
     * @var array<string, mixed>
     */
    public array $data = [];

    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        $innerData = self::extractInnerData(data: $data);

        $requestData = $innerData['service_proof_request'] ?? [];
        if (! is_array($requestData)) {
            $requestData = [];
        }
        /** @var array<string, mixed> $validatedRequest */
        $validatedRequest = $requestData;

        $response = new self();
        $response->result = self::extractResult(data: $data, rawResponse: $rawResponse);
        $response->id = TypeConverter::toInt($validatedRequest['id'] ?? null);
        $response->purchaseId = TypeConverter::toString($validatedRequest['purchase_id'] ?? null);
        $response->status = TypeConverter::toString($validatedRequest['status'] ?? null);
        $response->createdAt = TypeConverter::toDateTime($validatedRequest['created_at'] ?? null);
        $response->dueDate = TypeConverter::toDateTime($validatedRequest['due_date'] ?? null);
        $response->notes = TypeConverter::toString($validatedRequest['notes'] ?? null);
        $response->serviceProofRequest = $validatedRequest === []
            ? null
            : ServiceProofRequestData::fromArray($validatedRequest);
        $response->data = $validatedRequest;

        if ($rawResponse !== null) {
            $response->rawResponse = $rawResponse;
        }

        return $response;
    }
}
