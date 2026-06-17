<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Request\Purchase;

use GoSuccess\Digistore24\Api\Base\AbstractRequest;

/**
 * Request to resend purchase confirmation mail
 *
 * @link https://digistore24.com/api/docs/paths/resendPurchaseConfirmationMail.yaml OpenAPI Specification
 */
final class ResendPurchaseConfirmationMailRequest extends AbstractRequest
{
    /**
     * @param string $purchaseId The Digistore24 order ID
     */
    public function __construct(
        public string $purchaseId,
    ) {
    }

    public function getEndpoint(): string
    {
        return '/resendPurchaseConfirmationMail';
    }
}
