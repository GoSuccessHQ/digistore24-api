<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Resource;

use GoSuccess\Digistore24\Api\Base\AbstractResource;
use GoSuccess\Digistore24\Api\Request\Affiliate\GetAffiliateCommissionRequest;
use GoSuccess\Digistore24\Api\Request\Affiliate\GetAffiliateForEmailRequest;
use GoSuccess\Digistore24\Api\Request\Affiliate\GetReferringAffiliateRequest;
use GoSuccess\Digistore24\Api\Request\Affiliate\SetAffiliateForEmailRequest;
use GoSuccess\Digistore24\Api\Request\Affiliate\SetReferringAffiliateRequest;
use GoSuccess\Digistore24\Api\Request\Affiliate\UpdateAffiliateCommissionRequest;
use GoSuccess\Digistore24\Api\Request\Affiliate\ValidateAffiliateRequest;
use GoSuccess\Digistore24\Api\Response\Affiliate\GetAffiliateCommissionResponse;
use GoSuccess\Digistore24\Api\Response\Affiliate\GetAffiliateForEmailResponse;
use GoSuccess\Digistore24\Api\Response\Affiliate\GetReferringAffiliateResponse;
use GoSuccess\Digistore24\Api\Response\Affiliate\SetAffiliateForEmailResponse;
use GoSuccess\Digistore24\Api\Response\Affiliate\SetReferringAffiliateResponse;
use GoSuccess\Digistore24\Api\Response\Affiliate\UpdateAffiliateCommissionResponse;
use GoSuccess\Digistore24\Api\Response\Affiliate\ValidateAffiliateResponse;

/**
 * Affiliate Resource
 *
 * Provides methods to manage affiliate settings, commissions, and validations.
 */
final class AffiliateResource extends AbstractResource
{
    /**
     * Get affiliate commission settings for one or more products.
     *
     * @param GetAffiliateCommissionRequest $request Request containing the affiliate and product IDs
     * @return GetAffiliateCommissionResponse Response with commission settings
     */
    public function getCommission(GetAffiliateCommissionRequest $request): GetAffiliateCommissionResponse
    {
        return $this->executeTyped($request, GetAffiliateCommissionResponse::class);
    }

    /**
     * Update affiliate commission settings for one or more products.
     *
     * @param UpdateAffiliateCommissionRequest $request Request with the affiliate, product IDs and updated commission settings
     * @return UpdateAffiliateCommissionResponse Response confirming the update
     */
    public function updateCommission(UpdateAffiliateCommissionRequest $request): UpdateAffiliateCommissionResponse
    {
        return $this->executeTyped($request, UpdateAffiliateCommissionResponse::class);
    }

    /**
     * Get affiliate information by email address.
     *
     * @param GetAffiliateForEmailRequest $request Request containing email address
     * @return GetAffiliateForEmailResponse Response with affiliate information
     */
    public function getForEmail(GetAffiliateForEmailRequest $request): GetAffiliateForEmailResponse
    {
        return $this->executeTyped($request, GetAffiliateForEmailResponse::class);
    }

    /**
     * Set affiliate for a specific email address.
     *
     * @param SetAffiliateForEmailRequest $request Request containing email and affiliate ID
     * @return SetAffiliateForEmailResponse Response confirming the assignment
     */
    public function setForEmail(SetAffiliateForEmailRequest $request): SetAffiliateForEmailResponse
    {
        return $this->executeTyped($request, SetAffiliateForEmailResponse::class);
    }

    /**
     * Get the referring partner for an affiliate.
     *
     * @param GetReferringAffiliateRequest $request Request containing the affiliate ID
     * @return GetReferringAffiliateResponse Response with referring affiliate details
     */
    public function getReferring(GetReferringAffiliateRequest $request): GetReferringAffiliateResponse
    {
        return $this->executeTyped($request, GetReferringAffiliateResponse::class);
    }

    /**
     * Set the referring partner for an affiliate.
     *
     * @param SetReferringAffiliateRequest $request Request with the referrer ID and affiliate ID
     * @return SetReferringAffiliateResponse Response confirming the assignment
     */
    public function setReferring(SetReferringAffiliateRequest $request): SetReferringAffiliateResponse
    {
        return $this->executeTyped($request, SetReferringAffiliateResponse::class);
    }

    /**
     * Validate affiliate credentials.
     *
     * @param ValidateAffiliateRequest $request Request containing affiliate credentials
     * @return ValidateAffiliateResponse Response with validation result
     */
    public function validate(ValidateAffiliateRequest $request): ValidateAffiliateResponse
    {
        return $this->executeTyped($request, ValidateAffiliateResponse::class);
    }
}
