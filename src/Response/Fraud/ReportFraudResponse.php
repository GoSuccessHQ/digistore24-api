<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\Fraud;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\Http\Response;

/**
 * Response from reporting fraud.
 *
 * @see https://digistore24.com/api/docs/paths/reportFraud.yaml
 */
final class ReportFraudResponse extends AbstractResponse
{
    /**
     * Result status
     */
    public string $result = '';

    /**
     * Status of buyer report (info, success, warning, failure)
     */
    public string $buyerStatus = '';

    /**
     * Message about buyer report
     */
    public string $buyerMessage = '';

    /**
     * Code for buyer report (created_entry, rerequest, not_created)
     */
    public string $buyerCode = '';

    /**
     * Status of affiliate report (info, success, warning, failure)
     */
    public string $affiliateStatus = '';

    /**
     * Message about affiliate report
     */
    public string $affiliateMessage = '';

    /**
     * Code for affiliate report (created_entry, rerequest, not_created)
     */
    public string $affiliateCode = '';

    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        $innerData = self::extractInnerData(data: $data);

        $response = new self();
        $response->result = self::extractResult(data: $data, rawResponse: $rawResponse);
        $response->buyerStatus = is_string($innerData['buyer_status'] ?? null) ? $innerData['buyer_status'] : '';
        $response->buyerMessage = is_string($innerData['buyer_message'] ?? null) ? $innerData['buyer_message'] : '';
        $response->buyerCode = is_string($innerData['buyer_code'] ?? null) ? $innerData['buyer_code'] : '';
        $response->affiliateStatus = is_string($innerData['affiliate_status'] ?? null) ? $innerData['affiliate_status'] : '';
        $response->affiliateMessage = is_string($innerData['affiliate_message'] ?? null) ? $innerData['affiliate_message'] : '';
        $response->affiliateCode = is_string($innerData['affiliate_code'] ?? null) ? $innerData['affiliate_code'] : '';

        if ($rawResponse !== null) {
            $response->rawResponse = $rawResponse;
        }

        return $response;
    }
}
