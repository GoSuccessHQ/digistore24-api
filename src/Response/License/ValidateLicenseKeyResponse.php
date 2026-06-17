<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\License;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\Http\Response;

/**
 * Response from validating a license key.
 *
 * @see https://digistore24.com/api/docs/paths/validateLicenseKey.yaml
 */
final class ValidateLicenseKeyResponse extends AbstractResponse
{
    public string $result = '';

    public string $isLicenseValid = 'N';

    public string $isLicenseKeyFound = 'N';

    public string $purchaseId = '';

    public string $licenseKey = '';

    public int $productId = 0;

    public string $productName = '';

    public string $billingStatus = '';

    public string $billingStatusMsg = '';

    public ?string $lastPaymentAt = null;

    public ?string $lastPaymentAtMsg = null;

    public ?string $nextPaymentAt = null;

    public ?string $nextPaymentAtMsg = null;

    public ?string $lastTransactionType = null;

    public ?string $lastTransactionTypeMsg = null;

    public ?string $paidUntil = null;

    public ?string $paidUntilMsg = null;

    public function isValid(): bool
    {
        return $this->isLicenseValid === 'Y';
    }

    public function isFound(): bool
    {
        return $this->isLicenseKeyFound === 'Y';
    }

    public static function fromArray(array $data, ?Response $rawResponse = null): static
    {
        $innerData = self::extractInnerData(data: $data);

        $response = new self();
        $response->result = self::extractResult(data: $data, rawResponse: $rawResponse);
        $response->isLicenseValid = is_string($innerData['is_license_valid'] ?? null) ? $innerData['is_license_valid'] : 'N';
        $response->isLicenseKeyFound = is_string($innerData['is_license_key_found'] ?? null) ? $innerData['is_license_key_found'] : 'N';
        $response->purchaseId = is_string($innerData['purchase_id'] ?? null) ? $innerData['purchase_id'] : '';
        $response->licenseKey = is_string($innerData['license_key'] ?? null) ? $innerData['license_key'] : '';
        $response->productId = is_int($innerData['product_id'] ?? null) ? $innerData['product_id'] : 0;
        $response->productName = is_string($innerData['product_name'] ?? null) ? $innerData['product_name'] : '';
        $response->billingStatus = is_string($innerData['billing_tatus'] ?? null) ? $innerData['billing_tatus'] : '';
        $response->billingStatusMsg = is_string($innerData['billing_tatus_msg'] ?? null) ? $innerData['billing_tatus_msg'] : '';
        $response->lastPaymentAt = isset($innerData['last_payment_at']) && is_string($innerData['last_payment_at']) ? $innerData['last_payment_at'] : null;
        $response->lastPaymentAtMsg = isset($innerData['last_payment_at_msg']) && is_string($innerData['last_payment_at_msg']) ? $innerData['last_payment_at_msg'] : null;
        $response->nextPaymentAt = isset($innerData['next_payment_at']) && is_string($innerData['next_payment_at']) ? $innerData['next_payment_at'] : null;
        $response->nextPaymentAtMsg = isset($innerData['next_payment_at_msg']) && is_string($innerData['next_payment_at_msg']) ? $innerData['next_payment_at_msg'] : null;
        $response->lastTransactionType = isset($innerData['last_transaction_type']) && is_string($innerData['last_transaction_type']) ? $innerData['last_transaction_type'] : null;
        $response->lastTransactionTypeMsg = isset($innerData['last_transaction_type_msg']) && is_string($innerData['last_transaction_type_msg']) ? $innerData['last_transaction_type_msg'] : null;
        $response->paidUntil = isset($innerData['paid_until']) && is_string($innerData['paid_until']) ? $innerData['paid_until'] : null;
        $response->paidUntilMsg = isset($innerData['paid_until_msg']) && is_string($innerData['paid_until_msg']) ? $innerData['paid_until_msg'] : null;

        if ($rawResponse !== null) {
            $response->rawResponse = $rawResponse;
        }

        return $response;
    }
}
