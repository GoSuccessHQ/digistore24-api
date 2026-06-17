<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\DTO;

use GoSuccess\Digistore24\Api\Base\AbstractDataTransferObject;

/**
 * Customer To Affiliate Details Data
 *
 * The `data` object returned by getCustomerToAffiliateBuyerDetails for a single
 * buyer. Response-only DTO: all fields use get-only property hooks.
 *
 * @link https://digistore24.com/api/docs/paths/getCustomerToAffiliateBuyerDetails.yaml
 */
final class CustomerToAffiliateDetailsData extends AbstractDataTransferObject
{
    /**
     * Username assigned to the buyer if they become an affiliate
     */
    public ?string $customerAffiliateName = null {
        get => $this->customerAffiliateName;
    }

    /**
     * URL for the buyer to register as an affiliate
     */
    public ?string $customerToAffiliateUrl = null {
        get => $this->customerToAffiliateUrl;
    }

    /**
     * URL for the new affiliate to promote products
     */
    public ?string $customerAffiliatePromoUrl = null {
        get => $this->customerAffiliatePromoUrl;
    }
}
