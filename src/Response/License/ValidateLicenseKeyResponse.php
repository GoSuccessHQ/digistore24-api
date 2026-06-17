<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\License;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;
use GoSuccess\Digistore24\Api\Http\Response;
use GoSuccess\Digistore24\Api\Util\TypeConverter;

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
        $response->isLicenseValid = TypeConverter::toString($innerData['is_license_valid'] ?? null) ?? 'N';
        $response->isLicenseKeyFound = TypeConverter::toString($innerData['is_license_key_found'] ?? null) ?? 'N';
        $response->purchaseId = TypeConverter::toString($innerData['purchase_id'] ?? null) ?? '';
        $response->licenseKey = TypeConverter::toString($innerData['license_key'] ?? null) ?? '';
        $response->productId = TypeConverter::toInt($innerData['product_id'] ?? null) ?? 0;
        $response->productName = TypeConverter::toString($innerData['product_name'] ?? null) ?? '';
        // Note: the spec defines these keys with the typo "billing_tatus".
        $response->billingStatus = TypeConverter::toString($innerData['billing_tatus'] ?? null) ?? '';
        $response->billingStatusMsg = TypeConverter::toString($innerData['billing_tatus_msg'] ?? null) ?? '';
        $response->lastPaymentAt = TypeConverter::toString($innerData['last_payment_at'] ?? null);
        $response->lastPaymentAtMsg = TypeConverter::toString($innerData['last_payment_at_msg'] ?? null);
        $response->nextPaymentAt = TypeConverter::toString($innerData['next_payment_at'] ?? null);
        $response->nextPaymentAtMsg = TypeConverter::toString($innerData['next_payment_at_msg'] ?? null);
        $response->lastTransactionType = TypeConverter::toString($innerData['last_transaction_type'] ?? null);
        $response->lastTransactionTypeMsg = TypeConverter::toString($innerData['last_transaction_type_msg'] ?? null);
        $response->paidUntil = TypeConverter::toString($innerData['paid_until'] ?? null);
        $response->paidUntilMsg = TypeConverter::toString($innerData['paid_until_msg'] ?? null);

        if ($rawResponse !== null) {
            $response->rawResponse = $rawResponse;
        }

        return $response;
    }
}
