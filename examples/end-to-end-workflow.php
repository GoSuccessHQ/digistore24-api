<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\DTO\PaymentPlanFullData;
use GoSuccess\Digistore24\Api\Exception\ApiException;
use GoSuccess\Digistore24\Api\Exception\ForbiddenException;
use GoSuccess\Digistore24\Api\Exception\NotFoundException;
use GoSuccess\Digistore24\Api\Exception\ValidationException;
use GoSuccess\Digistore24\Api\Request\BuyUrl\CreateBuyUrlRequest;
use GoSuccess\Digistore24\Api\Request\PaymentPlan\CreatePaymentplanRequest;
use GoSuccess\Digistore24\Api\Request\Product\CreateProductRequest;
use GoSuccess\Digistore24\Api\Request\Purchase\GetPurchaseRequest;
use GoSuccess\Digistore24\Api\Request\Purchase\RefundPurchaseRequest;

/**
 * Example: End-to-End Business Workflow
 *
 * The per-endpoint docs show each call in isolation. This script chains the
 * whole flow together so you can see how the output of one step feeds into the
 * input of the next:
 *
 *   1. Create a product            -> yields a product id
 *   2. Attach a payment plan        -> uses that product id
 *   3. Generate a buy URL           -> uses that product id, hand it to a buyer
 *   4. Fetch the resulting purchase -> needs a real order id (from a webhook/IPN)
 *   5. Refund the purchase          -> needs that same order id
 *
 * The entire flow is wrapped in a single try/catch over the real exception
 * hierarchy so any API failure at any step is handled uniformly.
 */

// Initialize the Digistore24 client
$ds24 = new Digistore24(new Configuration('YOUR-API-KEY'));

try {
    // -----------------------------------------------------------------------
    // Step 1: Create a product.
    // The response carries the new product id, which every later step needs.
    // -----------------------------------------------------------------------
    echo "=== Step 1: Create product ===\n";
    $productResponse = $ds24->products->create(new CreateProductRequest(
        nameIntern: 'E2E Demo Product',
        nameDe: 'E2E Demo-Produkt',
        nameEn: 'E2E Demo Product',
    ));

    $productId = $productResponse->productId; // int
    echo "Created product id: {$productId}\n\n";

    // -----------------------------------------------------------------------
    // Step 2: Attach a one-time payment plan to the product we just created.
    // We feed $productId straight from step 1 into the payment plan request.
    // numberOfInstallments = 1 means a single (one-time) payment.
    // -----------------------------------------------------------------------
    echo "=== Step 2: Add a one-time payment plan ===\n";
    $plan = new PaymentPlanFullData();
    $plan->firstAmount = 49.00;       // one charge of 49.00
    $plan->currency = 'eur';          // auto-uppercased to 'EUR'
    $plan->numberOfInstallments = 1;  // 1 = single payment (0 = subscription, >=2 = installments)
    $plan->isActive = true;

    $planResponse = $ds24->paymentPlans->create(new CreatePaymentplanRequest(
        productId: $productId,
        paymentPlan: $plan,
    ));
    echo "Created payment plan id: {$planResponse->paymentplanId}\n\n";

    // -----------------------------------------------------------------------
    // Step 3: Generate a buy URL for the product.
    // This is the link you send to a customer so they can check out.
    // -----------------------------------------------------------------------
    echo "=== Step 3: Generate a buy URL ===\n";
    $buyUrlRequest = new CreateBuyUrlRequest();
    $buyUrlRequest->productId = $productId; // same id from step 1
    $buyUrlRequest->validUntil = '48h';

    $buyUrlResponse = $ds24->buyUrls->create($buyUrlRequest);
    echo "Send this URL to the customer: {$buyUrlResponse->url}\n";
    if ($buyUrlResponse->validUntil !== null) {
        echo "Valid until: {$buyUrlResponse->validUntil->format('Y-m-d H:i:s')}\n";
    }
    echo "\n";

    // -----------------------------------------------------------------------
    // Step 4: Fetch a purchase by its order id.
    //
    // NOTE: there is no order id yet at this point in a fresh script - an order
    // only exists once a customer has actually paid through the buy URL above.
    // In a real system you receive the order id via an IPN/webhook callback and
    // then look it up here. Replace 'ORDER_ID' with that real value.
    // -----------------------------------------------------------------------
    echo "=== Step 4: Fetch the purchase ===\n";
    $purchase = $ds24->purchases->get(new GetPurchaseRequest('ORDER_ID'));
    echo "Purchase {$purchase->purchaseId}: {$purchase->amount} {$purchase->currency}";
    echo " (status: {$purchase->billingStatus})\n\n";

    // -----------------------------------------------------------------------
    // Step 5: Refund the purchase.
    //
    // Uses the same order id as step 4. With force = false the refund only goes
    // through if the product's refund policy allows it; set force = true to
    // attempt the refund regardless of policy.
    // -----------------------------------------------------------------------
    echo "=== Step 5: Refund the purchase ===\n";
    $refundResponse = $ds24->purchases->refund(new RefundPurchaseRequest(
        purchaseId: 'ORDER_ID', // placeholder - use the real order id here
        force: false,
    ));
    echo $refundResponse->wasSuccessful()
        ? "Refund succeeded.\n"
        : "Refund was not successful.\n";
} catch (ValidationException $e) {
    // 400-class: the request payload was rejected (e.g. a required field missing).
    echo "Validation failed: {$e->getMessage()}\n";
} catch (ForbiddenException $e) {
    // 403: the API key lacks the rights for this action (e.g. refunds, billing on demand).
    echo "Forbidden: {$e->getMessage()}\n";
} catch (NotFoundException $e) {
    // 404: the referenced resource (e.g. the order id) does not exist.
    echo "Not found: {$e->getMessage()}\n";
} catch (ApiException $e) {
    // Catch-all base for every other API-side error.
    echo "API error: {$e->getMessage()}\n";
}

echo "\n=== Workflow finished ===\n";
