<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Resource;

use GoSuccess\Digistore24\Api\Base\AbstractResource;
use GoSuccess\Digistore24\Api\Exception\ApiException;
use GoSuccess\Digistore24\Api\Request\Purchase\AddBalanceToPurchaseRequest;
use GoSuccess\Digistore24\Api\Request\Purchase\CreateAddonChangePurchaseRequest;
use GoSuccess\Digistore24\Api\Request\Purchase\CreateUpgradePurchaseRequest;
use GoSuccess\Digistore24\Api\Request\Purchase\GetCustomerToAffiliateBuyerDetailsRequest;
use GoSuccess\Digistore24\Api\Request\Purchase\GetPurchaseDownloadsRequest;
use GoSuccess\Digistore24\Api\Request\Purchase\GetPurchaseRequest;
use GoSuccess\Digistore24\Api\Request\Purchase\GetPurchaseTrackingRequest;
use GoSuccess\Digistore24\Api\Request\Purchase\ListPurchasesOfEmailRequest;
use GoSuccess\Digistore24\Api\Request\Purchase\ListPurchasesRequest;
use GoSuccess\Digistore24\Api\Request\Purchase\RefundPartiallyRequest;
use GoSuccess\Digistore24\Api\Request\Purchase\RefundPurchaseRequest;
use GoSuccess\Digistore24\Api\Request\Purchase\ResendPurchaseConfirmationMailRequest;
use GoSuccess\Digistore24\Api\Request\Purchase\UpdatePurchaseRequest;
use GoSuccess\Digistore24\Api\Response\Purchase\AddBalanceToPurchaseResponse;
use GoSuccess\Digistore24\Api\Response\Purchase\CreateAddonChangePurchaseResponse;
use GoSuccess\Digistore24\Api\Response\Purchase\CreateUpgradePurchaseResponse;
use GoSuccess\Digistore24\Api\Response\Purchase\GetCustomerToAffiliateBuyerDetailsResponse;
use GoSuccess\Digistore24\Api\Response\Purchase\GetPurchaseDownloadsResponse;
use GoSuccess\Digistore24\Api\Response\Purchase\GetPurchaseResponse;
use GoSuccess\Digistore24\Api\Response\Purchase\GetPurchaseTrackingResponse;
use GoSuccess\Digistore24\Api\Response\Purchase\ListPurchasesOfEmailResponse;
use GoSuccess\Digistore24\Api\Response\Purchase\ListPurchasesResponse;
use GoSuccess\Digistore24\Api\Response\Purchase\RefundPartiallyResponse;
use GoSuccess\Digistore24\Api\Response\Purchase\RefundPurchaseResponse;
use GoSuccess\Digistore24\Api\Response\Purchase\ResendPurchaseConfirmationMailResponse;
use GoSuccess\Digistore24\Api\Response\Purchase\UpdatePurchaseResponse;

/**
 * Purchase Resource
 *
 * Retrieve and manage purchase information.
 *
 * @link https://digistore24.com/api/docs/tags/purchase
 */
final class PurchaseResource extends AbstractResource
{
    /**
     * Create addon change purchase
     *
     * Creates a package change order to add or remove products from an order.
     * The main product's quantity cannot be changed. Added products must be subscriptions.
     * Requires "Billing on demand" right to be enabled for the vendor account.
     *
     * @param CreateAddonChangePurchaseRequest $request The addon change request
     * @throws ApiException
     * @return CreateAddonChangePurchaseResponse The response
     * @link https://digistore24.com/api/docs/paths/createAddonChangePurchase.yaml
     */
    public function createAddonChange(CreateAddonChangePurchaseRequest $request): CreateAddonChangePurchaseResponse
    {
        return $this->executeTyped($request, CreateAddonChangePurchaseResponse::class);
    }

    /**
     * Get purchase details
     *
     * Retrieves detailed information about a specific purchase/order.
     *
     * @param GetPurchaseRequest $request The get purchase request
     * @throws ApiException
     * @return GetPurchaseResponse The response with purchase details
     * @link https://digistore24.com/api/docs/paths/getPurchase.yaml
     */
    public function get(GetPurchaseRequest $request): GetPurchaseResponse
    {
        return $this->executeTyped($request, GetPurchaseResponse::class);
    }

    /**
     * List all purchases
     *
     * Retrieves a list of all purchases, optionally filtered by product, buyer, or date range.
     *
     * @param ListPurchasesRequest|null $request Optional list purchases request with filters
     * @throws ApiException
     * @return ListPurchasesResponse The response with purchases list
     * @link https://digistore24.com/api/docs/paths/listPurchases.yaml
     */
    public function list(?ListPurchasesRequest $request = null): ListPurchasesResponse
    {
        return $this->executeTyped($request ?? new ListPurchasesRequest(), ListPurchasesResponse::class);
    }

    /**
     * List purchases by email address
     *
     * Retrieves all purchases belonging to a specific email address.
     *
     * @param ListPurchasesOfEmailRequest $request The list purchases by email request
     * @throws ApiException
     * @return ListPurchasesOfEmailResponse The response with purchases list
     * @link https://digistore24.com/api/docs/paths/listPurchasesOfEmail.yaml
     */
    public function listByEmail(ListPurchasesOfEmailRequest $request): ListPurchasesOfEmailResponse
    {
        return $this->executeTyped($request, ListPurchasesOfEmailResponse::class);
    }

    /**
     * Get purchase tracking information
     *
     * Returns tracking data for one or more orders including UTM parameters,
     * click IDs, sub IDs, vendor key, and campaign key.
     *
     * @param GetPurchaseTrackingRequest $request The get purchase tracking request
     * @throws ApiException
     * @return GetPurchaseTrackingResponse The response with tracking details
     * @link https://digistore24.com/api/docs/paths/getPurchaseTracking.yaml
     */
    public function getTracking(GetPurchaseTrackingRequest $request): GetPurchaseTrackingResponse
    {
        return $this->executeTyped($request, GetPurchaseTrackingResponse::class);
    }

    /**
     * Create upgrade purchase
     *
     * Performs an upgrade without user interaction. Requires full access rights
     * and "Billing on demand" permission. You must ensure the buyer is informed
     * and agrees to automatic upgrades.
     *
     * @param CreateUpgradePurchaseRequest $request The create upgrade purchase request
     * @throws ApiException
     * @return CreateUpgradePurchaseResponse The response with new purchase details
     * @link https://digistore24.com/api/docs/paths/createUpgradePurchase.yaml
     */
    public function createUpgrade(CreateUpgradePurchaseRequest $request): CreateUpgradePurchaseResponse
    {
        return $this->executeTyped($request, CreateUpgradePurchaseResponse::class);
    }

    /**
     * Add balance to purchase
     *
     * For subscription and installment payments - add balance to the order.
     * This will be billed with the next payments. Use negative amounts to
     * reduce balance (but total cannot go below 0).
     *
     * @param AddBalanceToPurchaseRequest $request The add balance request
     * @throws ApiException
     * @return AddBalanceToPurchaseResponse The response with old and new balance
     * @link https://digistore24.com/api/docs/paths/addBalanceToPurchase.yaml
     */
    public function addBalance(AddBalanceToPurchaseRequest $request): AddBalanceToPurchaseResponse
    {
        return $this->executeTyped($request, AddBalanceToPurchaseResponse::class);
    }

    /**
     * Update purchase
     *
     * Changes the tracking data of an order and can extend rebilling intervals.
     *
     * @param UpdatePurchaseRequest $request The update purchase request
     * @throws ApiException
     * @return UpdatePurchaseResponse The response indicating if purchase was modified
     * @link https://digistore24.com/api/docs/paths/updatePurchase.yaml
     */
    public function update(UpdatePurchaseRequest $request): UpdatePurchaseResponse
    {
        return $this->executeTyped($request, UpdatePurchaseResponse::class);
    }

    /**
     * Refund purchase
     *
     * Refunds all payments of an order which may be refunded according to refund policy.
     *
     * @param RefundPurchaseRequest $request The refund purchase request
     * @throws ApiException
     * @return RefundPurchaseResponse The response with refund result
     * @link https://digistore24.com/api/docs/paths/refundPurchase.yaml
     */
    public function refund(RefundPurchaseRequest $request): RefundPurchaseResponse
    {
        return $this->executeTyped($request, RefundPurchaseResponse::class);
    }

    /**
     * Partially refund a purchase
     *
     * Refunds a partial amount of a payment (not the complete payment). The refund
     * amount is treated as a discount and the order status does not change. Use
     * refund() for full refunds.
     *
     * @param RefundPartiallyRequest $request The partial refund request
     * @throws ApiException
     * @return RefundPartiallyResponse The response with the refund result
     * @link https://digistore24.com/api/docs/paths/refundPartially.yaml
     */
    public function refundPartially(RefundPartiallyRequest $request): RefundPartiallyResponse
    {
        return $this->executeTyped($request, RefundPartiallyResponse::class);
    }

    /**
     * Resend purchase confirmation mail
     *
     * Resends the order confirmation email to the buyer.
     *
     * @param ResendPurchaseConfirmationMailRequest $request The resend mail request
     * @throws ApiException
     * @return ResendPurchaseConfirmationMailResponse The response with send status
     * @link https://digistore24.com/api/docs/paths/resendPurchaseConfirmationMail.yaml
     */
    public function resendConfirmationMail(ResendPurchaseConfirmationMailRequest $request): ResendPurchaseConfirmationMailResponse
    {
        return $this->executeTyped($request, ResendPurchaseConfirmationMailResponse::class);
    }

    /**
     * Get purchase downloads
     *
     * Returns download information for purchased digital products including URLs,
     * download limits, access status, and file details.
     *
     * @param GetPurchaseDownloadsRequest $request The get downloads request
     * @throws ApiException
     * @return GetPurchaseDownloadsResponse The response with download details
     * @link https://digistore24.com/api/docs/paths/getPurchaseDownloads.yaml
     */
    public function getDownloads(GetPurchaseDownloadsRequest $request): GetPurchaseDownloadsResponse
    {
        return $this->executeTyped($request, GetPurchaseDownloadsResponse::class);
    }

    /**
     * Get customer-to-affiliate program details
     *
     * Returns details on the customer-to-affiliate program for specific buyer(s).
     * Requires customer-to-affiliate program to be set up in Digistore24 first.
     * Provides affiliate registration URL and promotion URL for the buyer.
     *
     * @param GetCustomerToAffiliateBuyerDetailsRequest $request The get customer affiliate details request
     * @throws ApiException
     * @return GetCustomerToAffiliateBuyerDetailsResponse The response with affiliate program details
     * @link https://digistore24.com/api/docs/paths/getCustomerToAffiliateBuyerDetails.yaml
     */
    public function getCustomerToAffiliateDetails(GetCustomerToAffiliateBuyerDetailsRequest $request): GetCustomerToAffiliateBuyerDetailsResponse
    {
        return $this->executeTyped($request, GetCustomerToAffiliateBuyerDetailsResponse::class);
    }
}
