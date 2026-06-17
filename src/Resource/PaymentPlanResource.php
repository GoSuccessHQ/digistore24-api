<?php

declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Resource;

use GoSuccess\Digistore24\Api\Base\AbstractResource;
use GoSuccess\Digistore24\Api\Request\PaymentPlan\CreatePaymentplanRequest;
use GoSuccess\Digistore24\Api\Request\PaymentPlan\DeletePaymentplanRequest;
use GoSuccess\Digistore24\Api\Request\PaymentPlan\ListPaymentPlansRequest;
use GoSuccess\Digistore24\Api\Request\PaymentPlan\UpdatePaymentplanRequest;
use GoSuccess\Digistore24\Api\Response\PaymentPlan\CreatePaymentplanResponse;
use GoSuccess\Digistore24\Api\Response\PaymentPlan\DeletePaymentplanResponse;
use GoSuccess\Digistore24\Api\Response\PaymentPlan\ListPaymentPlansResponse;
use GoSuccess\Digistore24\Api\Response\PaymentPlan\UpdatePaymentplanResponse;

/**
 * Payment Plan Resource
 *
 * Provides methods to manage payment plans for products.
 */
final class PaymentPlanResource extends AbstractResource
{
    /**
     * Create a new payment plan.
     *
     * @param CreatePaymentplanRequest $request Request with payment plan configuration
     * @return CreatePaymentplanResponse Response with created payment plan ID
     */
    public function create(CreatePaymentplanRequest $request): CreatePaymentplanResponse
    {
        return $this->executeTyped($request, CreatePaymentplanResponse::class);
    }

    /**
     * Update an existing payment plan.
     *
     * @param UpdatePaymentplanRequest $request Request with updated payment plan data
     * @return UpdatePaymentplanResponse Response confirming the update
     */
    public function update(UpdatePaymentplanRequest $request): UpdatePaymentplanResponse
    {
        return $this->executeTyped($request, UpdatePaymentplanResponse::class);
    }

    /**
     * Delete a payment plan.
     *
     * @param DeletePaymentplanRequest $request Request containing payment plan ID
     * @return DeletePaymentplanResponse Response confirming deletion
     */
    public function delete(DeletePaymentplanRequest $request): DeletePaymentplanResponse
    {
        return $this->executeTyped($request, DeletePaymentplanResponse::class);
    }

    /**
     * List the payment plans configured for a product.
     *
     * The Digistore24 listPaymentPlans endpoint requires a product ID. Pass the
     * product ID directly, or supply a pre-built request for full control.
     *
     * @param int|ListPaymentPlansRequest $product Product ID or a ready request
     * @return ListPaymentPlansResponse Response with list of payment plans
     */
    public function list(int|ListPaymentPlansRequest $product): ListPaymentPlansResponse
    {
        $request = $product instanceof ListPaymentPlansRequest
            ? $product
            : new ListPaymentPlansRequest(productId: $product);

        return $this->executeTyped($request, ListPaymentPlansResponse::class);
    }
}
