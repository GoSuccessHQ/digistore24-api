<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\DTO\PurchaseItemData;
use GoSuccess\Digistore24\Api\DTO\PurchaseTransactionData;
use GoSuccess\Digistore24\Api\Request\Purchase\GetPurchaseRequest;

/**
 * Example: Navigating a Fully-Typed Response
 *
 * The per-endpoint docs list the fields a response *has*; this script shows how
 * to actually *navigate* one end to end. getPurchase returns a deeply nested,
 * fully-typed object: scalar properties, a nested BuyerData object, and arrays
 * of typed item / transaction DTOs - all with IDE autocomplete and no manual
 * array digging.
 *
 * Replace 'ORDER_ID' with a real order id (received via an IPN/webhook).
 */

// Initialize the Digistore24 client
$ds24 = new Digistore24(new Configuration('YOUR-API-KEY'));

$purchase = $ds24->purchases->get(new GetPurchaseRequest('ORDER_ID'));

// ---------------------------------------------------------------------------
// 1. Typed scalar properties - no array keys, no casting.
// ---------------------------------------------------------------------------
echo "=== Order summary ===\n";
echo "Purchase ID:    {$purchase->purchaseId}\n"; // string
echo "Amount:         {$purchase->amount} {$purchase->currency}\n"; // float + string
echo "Billing status: " . ($purchase->billingStatus ?? 'n/a') . "\n\n"; // ?string

// ---------------------------------------------------------------------------
// 2. The nested typed buyer object (BuyerData), guarded for null.
// ---------------------------------------------------------------------------
echo "=== Buyer ===\n";
if ($purchase->buyer !== null) {
    $buyer = $purchase->buyer;
    echo "Email:   {$buyer->email}\n"; // string
    echo "Name:    " . ($buyer->firstName ?? '') . "\n"; // ?string
    echo "Country: " . ($buyer->country ?? 'n/a') . "\n"; // ?string
} else {
    echo "No buyer data on this purchase.\n";
}
echo "\n";

// ---------------------------------------------------------------------------
// 3. Iterate the typed product line items (array of PurchaseItemData).
// ---------------------------------------------------------------------------
echo "=== Items ===\n";
if ($purchase->items === []) {
    echo "No items.\n";
}
foreach ($purchase->items as $item) {
    /** @var PurchaseItemData $item */
    $name = $item->productName ?? 'unknown';
    $id = $item->productId ?? 0;
    $qty = $item->quantity ?? 1;
    echo "- [{$id}] {$name} x{$qty}\n";
}
echo "\n";

// ---------------------------------------------------------------------------
// 4. Iterate the typed transaction list (array of PurchaseTransactionData).
//    Each entry is one payment or refund booked against the order.
// ---------------------------------------------------------------------------
echo "=== Transactions ===\n";
if ($purchase->transactionList === []) {
    echo "No transactions.\n";
}
foreach ($purchase->transactionList as $transaction) {
    /** @var PurchaseTransactionData $transaction */
    $type = $transaction->type ?? 'unknown';       // 'payment' | 'refund'
    $amount = $transaction->amount ?? 0.0;          // ?float
    $currency = $transaction->currency ?? '';        // ?string
    $when = $transaction->createdAt?->format('Y-m-d H:i:s') ?? 'n/a'; // ?DateTimeImmutable
    $method = $transaction->payMethodMsg ?? $transaction->payMethod ?? 'n/a';
    echo "- {$type}: {$amount} {$currency} via {$method} on {$when}\n";
}
echo "\n";

// ---------------------------------------------------------------------------
// 5. Escape hatch: any field NOT surfaced as a typed property above is still
//    available verbatim in the full $purchase->data[...] array, exactly as the
//    API returned it. Useful for newly added or vendor-specific fields.
// ---------------------------------------------------------------------------
echo "=== Raw data escape hatch ===\n";
// e.g. a field with no dedicated typed property:
$payMethod = $purchase->data['pay_method'] ?? null;
echo 'pay_method (from raw data): ' . (is_scalar($payMethod) ? (string)$payMethod : 'n/a') . "\n";
echo 'Total raw fields available: ' . count($purchase->data) . "\n";
