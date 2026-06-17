# Migration Guide

## From 2.x to 3.0

Version 3.0 aligns the SDK with the Digistore24 OpenAPI spec. The public surface is
largely unchanged, but a few request/response classes changed. Most of these
"breaking" changes touch code paths that were previously broken.

### HTTP methods

Read/list/validate/stats endpoints now use GET, update endpoints use PUT, and
delete endpoints use DELETE (previously almost everything was POST). Method
signatures are unchanged — no code changes are needed unless you called
`getMethod()` directly.

### `refundPartially` moved to `PurchaseResource`

```php
// Before
$ds24->billing->refundPartially($request);
// After
$ds24->purchases->refundPartially($request);
```

Use `GoSuccess\Digistore24\Api\Request\Purchase\RefundPartiallyRequest` (the
`Billing\RefundPartially*` classes were removed). The non-spec `reason` parameter
was dropped.

### `UpdateBuyerRequest`

```php
// Before
new UpdateBuyerRequest('B1', address: ['street' => 'Main St', 'city' => 'Berlin']);
// After
new UpdateBuyerRequest('B1', streetName: 'Main St', city: 'Berlin', salutation: Salutation::MR);
```

The `$address` array is gone; pass the individual flat fields. `salutation` is a
`Salutation` enum.

### `UpdateDeliveryRequest`

Status fields are now nested under `data` in the payload, and the constructor gained
optional `$tracking` (a list of `DeliveryTrackingUpdateData`) and `$notifyViaEmail`
parameters.

### Product enums

`CreateProductRequest`/`UpdateProductRequest` now take `ProductApprovalStatus`
(new/pending) and `ProductBuyerType` (consumer/business) instead of
`AffiliateApprovalStatus`/`BuyerType`.

### `ShippingCostPolicyData` labels

```php
// Before
$policy->labelXX = 'Shipping';
// After
$policy->labels = ['en' => 'Shipping', 'de' => 'Versand'];
```

### Typed responses

`ValidateCouponCodeResponse` and `GetMarketplaceEntryResponse` expose typed
properties (e.g. `$response->couponId`, `$response->statsStars`) instead of a raw
`$data` array.

### Request validation

A request that fails its own `rules()` now throws a `ValidationException`
(HTTP 400, exposing `getErrors()`) from the resource method before any HTTP call.

### `CreatePaymentplanRequest`

`createPaymentplan` requires the product the plan belongs to, so the request now takes
a `$productId` before the data object:

```php
// Before
$ds24->paymentPlans->create(new CreatePaymentplanRequest($plan));
// After
$ds24->paymentPlans->create(new CreatePaymentplanRequest(productId: 123, paymentPlan: $plan));
```

### Corrected create/update payloads (no caller change)

Several entity create/update endpoints were sending their fields flat when the API
expects them nested under a `data` object, so the calls were silently ignored. This is
fixed inside the request classes -- existing calling code keeps working -- for
`createProductGroup`, `createOrderform`, `createVoucher`, `createShippingCostPolicy`,
`updateProductGroup`, `updateOrderform`, `updatePaymentplan`, and
`updateShippingCostPolicy`. The shipping-policy and service-proof endpoints now also
send the API's real parameter names (`policy_id`, `service_proof_id`).

### Fully-typed responses and request parameters

3.0 makes the SDK a complete binding: every response exposes all API fields as typed
properties (with nested DTOs) plus a `$response->data` array with the full payload, and
every request accepts every spec parameter. A few endpoints whose SDK signatures or
response fields were previously wrong have changed:

- **Responses** — where the SDK previously read a wrong key, the typed property may have
  moved. The clearest case is `getPurchase`: `$response->productId` and `$response->buyerEmail`
  are gone; use `$response->items[0]->productId` and `$response->buyer->email` (a typed
  `BuyerData`), or read `$response->data` for the complete payload. If a typed property you
  relied on is missing, it is almost always available under `$response->data[...]`.
- **Request constructors** changed to the real parameter names. Notable ones:
  `UpdateAffiliateCommissionRequest(productIds: 'all', ...)` (was `productId: int`);
  `GetEticketRequest(eticketId: ...)`, `ValidateEticketRequest(eticketId, templateId, locationId)`;
  `GetServiceProofRequestRequest`/`UpdateServiceProofRequestRequest` take `serviceProofId` (int);
  `ListAccountAccessRequest()` is parameterless; `ListPaymentPlansRequest(productId: ...)` is now
  required; the eticket/service-proof/delivery list endpoints take a search DTO.

---

## From `gosuccess/php-ds24-api-wrapper` to `gosuccess/digistore24-api`

This package has been renamed and refactored with breaking changes.

### Package Name Change

**Old:** `gosuccess/php-ds24-api-wrapper`
**New:** `gosuccess/digistore24-api`

### Installation

```bash
# Remove old package
composer remove gosuccess/php-ds24-api-wrapper

# Install new package
composer require gosuccess/digistore24-api
```

### Breaking Changes

#### 1. Namespace Change

**Old namespace:** `GoSuccess\Digistore24\`
**New namespace:** `GoSuccess\Digistore24\Api\`

**Before:**
```php
use GoSuccess\Digistore24\Digistore24;
use GoSuccess\Digistore24\Client\Configuration;
use GoSuccess\Digistore24\Request\BuyUrl\CreateBuyUrlRequest;
```

**After:**
```php
use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\Request\BuyUrl\CreateBuyUrlRequest;
```

#### 2. Constructor Changes

The `Digistore24` class now requires a `Configuration` object instead of individual parameters.

**Before:**
```php
$ds24 = new Digistore24(
    apiKey: 'YOUR-API-KEY',
    language: 'en',
    timeout: 30,
    debug: false
);
```

**After:**
```php
$config = new Configuration(
    apiKey: 'YOUR-API-KEY',
);

$ds24 = new Digistore24($config);
```

#### 3. Client Access

The `getClient()` method has been removed. Use the public `$client` property instead.

**Before:**
```php
$client = $ds24->getClient();
```

**After:**
```php
$client = $ds24->client;
```

#### 4. Utils Directory Renamed

**Old:** `GoSuccess\Digistore24\Utils\`
**New:** `GoSuccess\Digistore24\Api\Util\`

Note: `Utils` (plural) → `Util` (singular)

#### 5. Exception Namespace

**Old:** `GoSuccess\Digistore24\Exception\`
**New:** `GoSuccess\Digistore24\Api\Exception\`

### What's New

- **PHP 8.4 Property Hooks** - Automatic validation on property assignment
- **Lazy Loading** - Resources are initialized on-demand
- **Configuration Object** - Centralized configuration with validation
- **Computed Properties** - Properties like `$apiUrl` are automatically computed
- **Type Safety** - Enhanced type hints throughout the codebase
- **Optional Request Parameters** - Methods with all-optional parameters no longer require explicit Request objects

### New Feature: Optional Request Parameters

In version 2.0, methods with all-optional parameters can now be called without creating a Request object:

**Before (v1.x):**
```php
use GoSuccess\Digistore24\Api\Request\Product\ListProductsRequest;

// Always required Request object, even for simple calls
$request = new ListProductsRequest();
$products = $ds24->products->list($request);
```

**After (v2.0):**
```php
// Simple: No Request object needed
$products = $ds24->products->list();

// Advanced: Still works with Request object for filters
$products = $ds24->products->list(
    new ListProductsRequest(sortBy: 'name')
);
```

**Affected Methods (39+ methods across 27 Resources):**
- `$ds24->products->list()` - no parameters needed
- `$ds24->purchases->list()` - optional filters
- `$ds24->users->getInfo()` - no parameters needed
- `$ds24->system->ping()` - no parameters needed
- `$ds24->countries->listCountries()` - no parameters needed
- `$ds24->statistics->sales()` - optional date ranges
- And many more...

**Backward Compatibility:** All existing code with explicit Request objects continues to work.

### Example Migration

**Complete Before:**
```php
<?php

use GoSuccess\Digistore24\Digistore24;
use GoSuccess\Digistore24\Request\BuyUrl\CreateBuyUrlRequest;
use GoSuccess\Digistore24\DataTransferObject\BuyerData;

$ds24 = new Digistore24(
    apiKey: 'YOUR-API-KEY',
);

$request = new CreateBuyUrlRequest();
$request->productId = 12345;
$response = $ds24->buyUrls->create($request);
```

**Complete After:**
```php
<?php

use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\Request\BuyUrl\CreateBuyUrlRequest;
use GoSuccess\Digistore24\Api\DTO\BuyerData;

$config = new Configuration(
    apiKey: 'YOUR-API-KEY',
);

$ds24 = new Digistore24($config);

$request = new CreateBuyUrlRequest();
$request->productId = 12345;
$response = $ds24->buyUrls->create($request);
```

### Find & Replace Guide

Use your IDE's find & replace feature:

1. **Namespace imports:**
   - Find: `use GoSuccess\Digistore24\`
   - Replace: `use GoSuccess\Digistore24\Api\`

2. **Exception catches:**
   - Find: `\GoSuccess\Digistore24\Exception\`
   - Replace: `\GoSuccess\Digistore24\Api\Exception\`

3. **Utils references:**
   - Find: `GoSuccess\Digistore24\Utils\`
   - Replace: `GoSuccess\Digistore24\Api\Util\`

### Need Help?

If you encounter any issues during migration:

1. Check the [README.md](README.md) for updated examples
2. Review the [examples/](examples/) directory for complete usage examples
3. Open an issue on [GitHub](https://github.com/GoSuccessHQ/digistore24-api/issues)

### Why the Change?

- **Better Namespace Structure** - Aligns with our existing `digistore24-ipn` package
- **Clearer Package Name** - Reflects that this is an API client, not just a wrapper
- **Modern Architecture** - Leverages PHP 8.4 features for better developer experience
- **Consistency** - Part of the `GoSuccess\Digistore24\*` package family
