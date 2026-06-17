<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Request\Affiliate;

use GoSuccess\Digistore24\Api\Base\AbstractRequest;

/**
 * Get Affiliate For Email Request
 *
 * Retrieves affiliate information for a specific email address.
 */
final class GetAffiliateForEmailRequest extends AbstractRequest
{
    /**
     * @param string $email The email address to look up
     */
    public function __construct(
        private string $email,
    ) {
    }

    public function getEndpoint(): string
    {
        return '/getAffiliateForEmail';
    }

    public function toArray(): array
    {
        return ['email' => $this->email];
    }
}
