<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Request\Affiliate;

use GoSuccess\Digistore24\Api\Base\AbstractRequest;

/**
 * Set Affiliate For Email Request
 *
 * Assigns an affiliate to a specific email address (the future buyer).
 */
final class SetAffiliateForEmailRequest extends AbstractRequest
{
    /**
     * @param string $email The email address of the future buyer
     * @param string $affiliate The affiliate's Digistore24 ID
     * @param string|null $campaignkey The affiliate's campaign key
     * @param string|null $trackingkey Your tracking key
     * @param string|null $clickId Your affiliate's click ID (for their S2S postback connection)
     */
    public function __construct(
        private string $email,
        private string $affiliate,
        private ?string $campaignkey = null,
        private ?string $trackingkey = null,
        private ?string $clickId = null,
    ) {
    }

    public function getEndpoint(): string
    {
        return '/setAffiliateForEmail';
    }

    public function toArray(): array
    {
        $data = [
            'email' => $this->email,
            'affiliate' => $this->affiliate,
        ];

        if ($this->campaignkey !== null) {
            $data['campaignkey'] = $this->campaignkey;
        }
        if ($this->trackingkey !== null) {
            $data['trackingkey'] = $this->trackingkey;
        }
        if ($this->clickId !== null) {
            $data['click_id'] = $this->clickId;
        }

        return $data;
    }
}
