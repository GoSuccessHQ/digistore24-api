<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\Fraud;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\Http\Response;
use GoSuccess\Digistore24\Api\Util\TypeConverter;

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
        $response->buyerStatus = TypeConverter::toString($innerData['buyer_status'] ?? null) ?? '';
        $response->buyerMessage = TypeConverter::toString($innerData['buyer_message'] ?? null) ?? '';
        $response->buyerCode = TypeConverter::toString($innerData['buyer_code'] ?? null) ?? '';
        $response->affiliateStatus = TypeConverter::toString($innerData['affiliate_status'] ?? null) ?? '';
        $response->affiliateMessage = TypeConverter::toString($innerData['affiliate_message'] ?? null) ?? '';
        $response->affiliateCode = TypeConverter::toString($innerData['affiliate_code'] ?? null) ?? '';

        if ($rawResponse !== null) {
            $response->rawResponse = $rawResponse;
        }

        return $response;
    }
}
