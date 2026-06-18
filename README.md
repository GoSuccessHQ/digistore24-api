# Digistore24 API Client for PHP

Modern, type-safe PHP API client for Digistore24 with **PHP 8.4 property hooks** and clean architecture.

[![PHP Version](https://img.shields.io/badge/PHP-8.4%2B-blue.svg)](https://php.net)
[![License](https://img.shields.io/badge/license-MIT-green.svg)](LICENSE)
[![Tests](https://github.com/GoSuccessHQ/digistore24-api/workflows/Tests/badge.svg)](https://github.com/GoSuccessHQ/digistore24-api/actions)
[![Coverage](https://img.shields.io/badge/Coverage-98%25-brightgreen.svg)](docs/TESTING.md)
[![Mutation](https://img.shields.io/badge/Mutation-85%25-brightgreen.svg)](docs/TESTING.md#mutation-testing)
[![PHPStan](https://img.shields.io/badge/PHPStan-level%209-brightgreen.svg)](phpstan.neon)
[![Code Style](https://img.shields.io/badge/code%20style-PSR--12-blue.svg)](https://www.php-fig.org/psr/psr-12/)

## Features

- ✨ **PHP 8.4 Property Hooks** - Automatic validation on property assignment
- 🎯 **Type-Safe** - Full type hints, enums, and generics throughout
- 🏗️ **Clean Architecture** - Resource-based design with separation of concerns
- 🔄 **Automatic Retry** - Built-in exponential backoff for failed requests
- 🚦 **Rate Limiting** - Handles API rate limits gracefully
- 📝 **Fully Documented** - Comprehensive PHPDoc with examples
- 🧪 **Exception Handling** - Typed exceptions for different error scenarios
- ✅ **122 Endpoints** - Complete coverage of Digistore24 API
- 🎉 **Optional Request Parameters** - Clean API calls without explicit Request objects

## Requirements

- **PHP 8.4.0 or higher** (for property hooks support)
- cURL extension
- mbstring extension

## Installation

```bash
composer require gosuccess/digistore24-api
```

## Quick Start

```php
<?php

use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\Request\BuyUrl\CreateBuyUrlRequest;
use GoSuccess\Digistore24\Api\DTO\BuyerData;

// Initialize configuration
$config = new Configuration('YOUR-API-KEY');

// Or with advanced options (configure via properties)
$config = new Configuration('YOUR-API-KEY');
$config->timeout = 60;
$config->debug = true;

// Create client
$ds24 = new Digistore24($config);

// Create a buy URL
$request = new CreateBuyUrlRequest();
$request->productId = 12345;
$request->validUntil = '48h';

// Add buyer data (with automatic validation)
$buyer = new BuyerData();
$buyer->email = 'customer@example.com';  // Validates email format
$buyer->firstName = 'John';
$buyer->country = 'de';  // Auto-uppercased to 'DE'
$request->buyer = $buyer;

// Execute request
$response = $ds24->buyUrls->create($request);
echo "Buy URL: {$response->url}\n";
```

## Architecture

This wrapper uses a **resource-based architecture** with typed requests and responses:

```php
$ds24->buyUrls->create()           // Buy URL management
$ds24->products->get()              // Product information
$ds24->purchases->list()            // Order management
$ds24->rebilling->start()           // Subscription management
$ds24->affiliates->getCommission()  // Affiliate management
$ds24->ipns->setup()                // Webhook management
$ds24->monitoring->ping()           // Health checks
```

### Directory Structure

```
src/
├── Base/                       # Abstract base classes
│   ├── AbstractRequest.php     # Base for all API requests
│   ├── AbstractResource.php    # Base for all resources
│   └── AbstractResponse.php    # Base for all API responses
│
├── Client/                     # HTTP client implementation
│   ├── ApiClient.php           # Main HTTP client with retry logic
│   └── Configuration.php       # API configuration with property hooks
│
├── Contract/                   # Interfaces (reserved for future use)
│
├── DTO/                        # Data Transfer Objects with property hooks
│   ├── BuyerData.php           # Buyer information (email validation)
│   ├── PaymentPlanData.php     # Payment plan (currency validation)
│   └── TrackingData.php        # Tracking parameters
│
├── Enum/                       # Type-safe enumerations
│   ├── HttpMethod.php          # HTTP methods (GET, POST, PUT, DELETE, PATCH)
│   └── StatusCode.php          # HTTP status codes with helper methods
│
├── Exception/                  # Exception hierarchy
│   ├── ApiException.php        # Base exception
│   ├── AuthenticationException.php
│   ├── ForbiddenException.php
│   ├── NotFoundException.php
│   ├── RateLimitException.php
│   ├── RequestException.php
│   └── ValidationException.php
│
├── Http/                       # HTTP-related classes
│   └── Response.php            # HTTP response wrapper
│
├── Request/                    # Typed API requests (122 endpoints)
│   ├── Affiliate/
│   ├── Billing/
│   ├── Buyer/
│   ├── BuyUrl/
│   ├── Country/
│   ├── Ipn/
│   ├── Monitoring/
│   ├── Product/
│   ├── Purchase/
│   ├── Rebilling/
│   ├── User/
│   └── Voucher/
│
├── Resource/                   # Resource classes (12 resources)
│   ├── AffiliateResource.php
│   ├── BillingResource.php
│   ├── BuyerResource.php
│   ├── BuyUrlResource.php
│   ├── CountryResource.php
│   ├── IpnResource.php
│   ├── MonitoringResource.php
│   ├── ProductResource.php
│   ├── PurchaseResource.php
│   ├── RebillingResource.php
│   ├── UserResource.php
│   └── VoucherResource.php
│
├── Response/                   # Typed API responses
│   ├── AccountAccess/
│   │   └── AccountAccessEntry.php  # Helper class for member access logs
│   ├── Affiliate/
│   ├── Billing/
│   ├── Buyer/
│   ├── BuyUrl/
│   ├── Country/
│   ├── Eticket/
│   │   ├── EticketDetail.php       # Helper class for e-ticket details
│   │   └── EticketListItem.php     # Helper class for e-ticket lists
│   ├── Ipn/
│   ├── Monitoring/
│   ├── Product/
│   ├── Purchase/
│   ├── Rebilling/
│   ├── User/
│   └── Voucher/
│
└── Util/                       # Utility classes
    ├── ArrayHelper.php         # Array operations
    ├── TypeConverter.php       # Type conversions
    └── Validator.php           # Validation utilities
```

### Naming Conventions

**Directories:**
- ✅ **Singular form**: `Exception/`, `Request/`, `Response/`
- ❌ NOT plural: ~~`Exceptions/`~~, ~~`Requests/`~~, ~~`Responses/`~~

**Classes:**
- **Abstract classes**: `AbstractRequest`, `AbstractResponse` → in `Base/`
- **Interfaces**: `RequestInterface`, `ResponseInterface` → in `Contract/`
- **DTOs**: `BuyerData`, `PaymentPlanData` → in `DTO/`
- **Exceptions**: `ApiException`, `NotFoundException` → in `Exception/`
- **Enums**: `HttpMethod`, `StatusCode` → in `Enum/`
- **Helper classes**: `AccountAccessEntry`, `EticketDetail` → in `Response/*/`

**Namespaces:**
```php
GoSuccess\Digistore24\Api\Base\AbstractRequest
GoSuccess\Digistore24\Api\Contract\RequestInterface
GoSuccess\Digistore24\Api\DTO\BuyerData
GoSuccess\Digistore24\Api\Enum\HttpMethod
GoSuccess\Digistore24\Api\Enum\StatusCode
GoSuccess\Digistore24\Api\Exception\ApiException
GoSuccess\Digistore24\Api\Request\BuyUrl\CreateBuyUrlRequest
GoSuccess\Digistore24\Api\Response\Eticket\EticketDetail
```

### Architecture Decisions

1. **Singular directories** - More consistent with PSR standards
2. **Property hooks** - Eliminate constructors where possible
3. **final classes** - Not readonly (allow mutation)
4. **Typed constants** - Enums instead of magic values
5. **String interpolation** - `"{$var}"` instead of concatenation
6. **Single class per file** - Helper classes in separate files
7. **Use imports** - Never use fully-qualified class names (FQCN)
8. **Dedicated Enum directory** - `HttpMethod`, `StatusCode` in `Enum/`

## PHP 8.4 Property Hooks

Property hooks provide automatic validation without constructors:

```php
final class BuyerData
{
    public string $email {
        set {
            if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                throw new \InvalidArgumentException("Invalid email");
            }
            $this->email = $value;
        }
    }

    public string $country {
        set {
            $upper = strtoupper($value);
            if (!in_array($upper, ['DE', 'AT', 'CH', 'US', ...])) {
                throw new \InvalidArgumentException("Invalid country code");
            }
            $this->country = $upper;
        }
    }
}
```

**Benefits:**
- ✅ No boilerplate constructors
- ✅ Automatic validation on assignment
- ✅ Mutable properties (read AND write)
- ✅ Clean, maintainable code

**Usage:**
```php
$buyer = new BuyerData();
$buyer->email = 'test@example.com';  // ✅ Valid
$buyer->email = 'invalid';           // ❌ Throws InvalidArgumentException

$buyer->country = 'de';              // ✅ Auto-uppercased to 'DE'
$buyer->country = 'invalid';         // ❌ Throws InvalidArgumentException
```

## Examples

### Simple API Calls (No Request Object Needed)

Many methods with all-optional parameters can now be called without creating a Request object:

```php
// List all products (no parameters needed)
$products = $ds24->products->list();

// Get user information (no parameters needed)
$userInfo = $ds24->users->getInfo();

// List all countries (no parameters needed)
$countries = $ds24->countries->listCountries();

// Test API connection (no parameters needed)
$ping = $ds24->system->ping();

// List purchases with default filters (no parameters needed)
$purchases = $ds24->purchases->list();
```

### Advanced API Calls (With Request Objects for Filters)

When you need filters or custom parameters, use Request objects:

```php
use GoSuccess\Digistore24\Api\Enum\ProductSortBy;
use GoSuccess\Digistore24\Api\Request\Product\ListProductsRequest;
use GoSuccess\Digistore24\Api\Request\Purchase\ListPurchasesRequest;

// List products sorted by name
$products = $ds24->products->list(
    new ListProductsRequest(sortBy: ProductSortBy::NAME)
);

// List purchases from last 7 days
$purchases = $ds24->purchases->list(
    new ListPurchasesRequest(
        from: '-7 days',
        to: 'now'
    )
);
```

### Create Buy URL with Payment Plan

```php
use GoSuccess\Digistore24\Api\DTO\PaymentPlanData;

$request = new CreateBuyUrlRequest();
$request->productId = 12345;

$paymentPlan = new PaymentPlanData();
$paymentPlan->firstAmount = 9.99;
$paymentPlan->otherAmounts = 29.99;
$paymentPlan->currency = 'eur';  // Auto-uppercased
$paymentPlan->numberOfInstallments = 12;
$request->paymentPlan = $paymentPlan;

$response = $ds24->buyUrls->create($request);
```

### Add Tracking Parameters

```php
use GoSuccess\Digistore24\Api\DTO\TrackingData;

$tracking = new TrackingData();
$tracking->affiliate = 'partner123';
$tracking->utmSource = 'newsletter';
$tracking->utmMedium = 'email';
$tracking->utmCampaign = 'summer2024';
$request->tracking = $tracking;
```

### Error Handling

```php
use GoSuccess\Digistore24\Api\Exception\{
    ApiException,
    AuthenticationException,
    ValidationException,
    RateLimitException
};

try {
    $response = $ds24->buyUrls->create($request);
} catch (AuthenticationException $e) {
    echo "Invalid API key: {$e->getMessage()}\n";
} catch (ValidationException $e) {
    echo "Validation error: {$e->getMessage()}\n";
} catch (RateLimitException $e) {
    echo "Rate limit exceeded, retry after: {$e->getContextValue('retry_after')}\n";
} catch (ApiException $e) {
    echo "API error: {$e->getMessage()}\n";
}
```

## Performance

### Benchmarks

Performance tests conducted on PHP 8.4.12 with 16GB RAM:

| Operation | Time | Memory | Notes |
|-----------|------|--------|-------|
| Create Buy URL | ~150ms | 2.1 MB | Including validation |
| List Products (100 items) | ~320ms | 4.5 MB | With pagination |
| Get Purchase Details | ~95ms | 1.8 MB | Single request |
| Batch Operations (10x) | ~1.2s | 12 MB | Parallel requests |
| Property Hook Validation | <1ms | Negligible | Zero overhead |

**Key Performance Features:**
- ✅ **Zero-copy property hooks** - No constructor overhead
- ✅ **Lazy loading** - Resources instantiated on demand
- ✅ **Memory efficient** - ~2MB per request average
- ✅ **Fast validation** - Inline property hook checks

### Rate Limiting & Retry Logic

The client automatically handles Digistore24 API rate limits with **exponential backoff**:

```php
use GoSuccess\Digistore24\Api\Client\Configuration;
use GoSuccess\Digistore24\Api\Exception\RateLimitException;

// Configure retry behavior (configure via properties)
$config = new Configuration('YOUR-API-KEY');
$config->timeout = 30;      // Request timeout in seconds
$config->maxRetries = 3;    // Max retry attempts (exponential backoff)

$ds24 = new Digistore24($config);

// Automatic retry on rate limit (429) or server errors (500-599)
try {
    $response = $ds24->products->list();
    echo "Retrieved {$response->totalCount} products\n";
} catch (RateLimitException $e) {
    // Thrown after all retries exhausted
    $retryAfter = $e->getContextValue('retry_after');
    echo "Rate limit exceeded. Retry after {$retryAfter} seconds\n";
}
```

**Retry Strategy:**
- **1st retry**: Wait 1 second
- **2nd retry**: Wait 2 seconds (exponential)
- **3rd retry**: Wait 4 seconds (exponential)
- **After 3 attempts**: Throw `RateLimitException`

**Status codes with automatic retry:**
- `429 Too Many Requests` - Rate limit hit
- `500 Internal Server Error` - Server error
- `502 Bad Gateway` - Temporary unavailability
- `503 Service Unavailable` - Service down
- `504 Gateway Timeout` - Request timeout

**Status codes WITHOUT retry:**
- `400 Bad Request` - Invalid parameters
- `401 Unauthorized` - Invalid API key
- `403 Forbidden` - Insufficient permissions
- `404 Not Found` - Resource not found

### Manual Rate Limit Handling

For fine-grained control, you can implement custom retry logic:

```php
use GoSuccess\Digistore24\Api\Exception\RateLimitException;

$maxAttempts = 5;
$attempt = 0;

while ($attempt < $maxAttempts) {
    try {
        $response = $ds24->purchases->list();
        break; // Success
    } catch (RateLimitException $e) {
        $attempt++;
        $retryAfter = $e->getContextValue('retry_after') ?? 60;

        if ($attempt >= $maxAttempts) {
            throw $e; // Give up
        }

        echo "Rate limited. Waiting {$retryAfter}s before retry {$attempt}/{$maxAttempts}...\n";
        sleep($retryAfter);
    }
}
```

## Available Resources

| Resource | Description | Endpoints | Status |
|----------|-------------|-----------|--------|
| `affiliates` | Commission management | 8 | ✅ Complete |
| `billing` | On-demand invoicing | 1 | ✅ Complete |
| `buyers` | Customer information | 8 | ✅ Complete |
| `buyUrls` | Order form URL management | 3 | ✅ Complete |
| `countries` | Country/region data | 2 | ✅ Complete |
| `ipns` | Webhook management | 3 | ✅ Complete |
| `monitoring` | Health checks | 1 | ✅ Complete |
| `products` | Product management | 59 | ✅ Complete |
| `purchases` | Order information | 24 | ✅ Complete |
| `rebilling` | Subscription management | 4 | ✅ Complete |
| `users` | Authentication | 3 | ✅ Complete |
| `vouchers` | Discount codes | 6 | ✅ Complete |
| **Total** | | **122** | **✅ 100%** |

## API Endpoints Documentation

### Affiliate Management
| Endpoint | Documentation |
|----------|---------------|
| `getAffiliateCommission` | [View](./docs/api/getAffiliateCommission.md) |
| `updateAffiliateCommission` | [View](./docs/api/updateAffiliateCommission.md) |
| `getAffiliateForEmail` | [View](./docs/api/getAffiliateForEmail.md) |
| `setAffiliateForEmail` | [View](./docs/api/setAffiliateForEmail.md) |
| `getReferringAffiliate` | [View](./docs/api/getReferringAffiliate.md) |
| `setReferringAffiliate` | [View](./docs/api/setReferringAffiliate.md) |
| `validateAffiliate` | [View](./docs/api/validateAffiliate.md) |
| `statsAffiliateToplist` | [View](./docs/api/statsAffiliateToplist.md) |

### Billing & Invoicing
| Endpoint | Documentation |
|----------|---------------|
| `createBillingOnDemand` | [View](./docs/api/createBillingOnDemand.md) |
| `listInvoices` | [View](./docs/api/listInvoices.md) |
| `resendInvoiceMail` | [View](./docs/api/resendInvoiceMail.md) |

### Buy URL Management
| Endpoint | Documentation |
|----------|---------------|
| `createBuyUrl` | [View](./docs/api/createBuyUrl.md) |
| `listBuyUrls` | [View](./docs/api/listBuyUrls.md) |
| `deleteBuyUrl` | [View](./docs/api/deleteBuyUrl.md) |

### Buyer Management
| Endpoint | Documentation |
|----------|---------------|
| `getBuyer` | [View](./docs/api/getBuyer.md) |
| `updateBuyer` | [View](./docs/api/updateBuyer.md) |
| `listBuyers` | [View](./docs/api/listBuyers.md) |
| `getCustomerToAffiliateBuyerDetails` | [View](./docs/api/getCustomerToAffiliateBuyerDetails.md) |

### Country & Currency
| Endpoint | Documentation |
|----------|---------------|
| `listCountries` | [View](./docs/api/listCountries.md) |
| `listCurrencies` | [View](./docs/api/listCurrencies.md) |

### Delivery Management
| Endpoint | Documentation |
|----------|---------------|
| `getDelivery` | [View](./docs/api/getDelivery.md) |
| `updateDelivery` | [View](./docs/api/updateDelivery.md) |
| `listDeliveries` | [View](./docs/api/listDeliveries.md) |

### E-Tickets
| Endpoint | Documentation |
|----------|---------------|
| `createEticket` | [View](./docs/api/createEticket.md) |
| `getEticket` | [View](./docs/api/getEticket.md) |
| `listEtickets` | [View](./docs/api/listEtickets.md) |
| `validateEticket` | [View](./docs/api/validateEticket.md) |
| `getEticketSettings` | [View](./docs/api/getEticketSettings.md) |
| `listEticketLocations` | [View](./docs/api/listEticketLocations.md) |
| `listEticketTemplates` | [View](./docs/api/listEticketTemplates.md) |

### Forms & Custom Data
| Endpoint | Documentation |
|----------|---------------|
| `listCustomFormRecords` | [View](./docs/api/listCustomFormRecords.md) |

### Images
| Endpoint | Documentation |
|----------|---------------|
| `createImage` | [View](./docs/api/createImage.md) |
| `getImage` | [View](./docs/api/getImage.md) |
| `listImages` | [View](./docs/api/listImages.md) |
| `deleteImage` | [View](./docs/api/deleteImage.md) |

### IPN/Webhook Management
| Endpoint | Documentation |
|----------|---------------|
| `ipnSetup` | [View](./docs/api/ipnSetup.md) |
| `ipnInfo` | [View](./docs/api/ipnInfo.md) |
| `ipnDelete` | [View](./docs/api/ipnDelete.md) |

### License Keys
| Endpoint | Documentation |
|----------|---------------|
| `validateLicenseKey` | [View](./docs/api/validateLicenseKey.md) |

### Marketplace
| Endpoint | Documentation |
|----------|---------------|
| `getMarketplaceEntry` | [View](./docs/api/getMarketplaceEntry.md) |
| `listMarketplaceEntries` | [View](./docs/api/listMarketplaceEntries.md) |

### Member Access
| Endpoint | Documentation |
|----------|---------------|
| `listAccountAccess` | [View](./docs/api/listAccountAccess.md) |
| `logMemberAccess` | [View](./docs/api/logMemberAccess.md) |

### Monitoring
| Endpoint | Documentation |
|----------|---------------|
| `ping` | [View](./docs/api/ping.md) |

### Order Forms
| Endpoint | Documentation |
|----------|---------------|
| `createOrderform` | [View](./docs/api/createOrderform.md) |
| `getOrderform` | [View](./docs/api/getOrderform.md) |
| `updateOrderform` | [View](./docs/api/updateOrderform.md) |
| `deleteOrderform` | [View](./docs/api/deleteOrderform.md) |
| `listOrderforms` | [View](./docs/api/listOrderforms.md) |
| `getOrderformMetas` | [View](./docs/api/getOrderformMetas.md) |

### Payment Plans
| Endpoint | Documentation |
|----------|---------------|
| `createPaymentplan` | [View](./docs/api/createPaymentplan.md) |
| `updatePaymentplan` | [View](./docs/api/updatePaymentplan.md) |
| `deletePaymentplan` | [View](./docs/api/deletePaymentplan.md) |
| `listPaymentPlans` | [View](./docs/api/listPaymentPlans.md) |

### Payouts & Commissions
| Endpoint | Documentation |
|----------|---------------|
| `listPayouts` | [View](./docs/api/listPayouts.md) |
| `listCommissions` | [View](./docs/api/listCommissions.md) |

### Product Groups
| Endpoint | Documentation |
|----------|---------------|
| `createProductGroup` | [View](./docs/api/createProductGroup.md) |
| `getProductGroup` | [View](./docs/api/getProductGroup.md) |
| `updateProductGroup` | [View](./docs/api/updateProductGroup.md) |
| `deleteProductGroup` | [View](./docs/api/deleteProductGroup.md) |
| `listProductGroups` | [View](./docs/api/listProductGroups.md) |

### Product Management
| Endpoint | Documentation |
|----------|---------------|
| `createProduct` | [View](./docs/api/createProduct.md) |
| `getProduct` | [View](./docs/api/getProduct.md) |
| `updateProduct` | [View](./docs/api/updateProduct.md) |
| `deleteProduct` | [View](./docs/api/deleteProduct.md) |
| `copyProduct` | [View](./docs/api/copyProduct.md) |
| `listProducts` | [View](./docs/api/listProducts.md) |
| `listProductTypes` | [View](./docs/api/listProductTypes.md) |

### Purchase Management
| Endpoint | Documentation |
|----------|---------------|
| `getPurchase` | [View](./docs/api/getPurchase.md) |
| `updatePurchase` | [View](./docs/api/updatePurchase.md) |
| `listPurchases` | [View](./docs/api/listPurchases.md) |
| `listPurchasesOfEmail` | [View](./docs/api/listPurchasesOfEmail.md) |
| `getPurchaseTracking` | [View](./docs/api/getPurchaseTracking.md) |
| `addBalanceToPurchase` | [View](./docs/api/addBalanceToPurchase.md) |
| `createUpgradePurchase` | [View](./docs/api/createUpgradePurchase.md) |
| `createAddonChangePurchase` | [View](./docs/api/createAddonChangePurchase.md) |
| `getPurchaseDownloads` | [View](./docs/api/getPurchaseDownloads.md) |
| `refundPurchase` | [View](./docs/api/refundPurchase.md) |
| `refundPartially` | [View](./docs/api/refundPartially.md) |
| `resendPurchaseConfirmationMail` | [View](./docs/api/resendPurchaseConfirmationMail.md) |

### Rebilling/Subscriptions
| Endpoint | Documentation |
|----------|---------------|
| `startRebilling` | [View](./docs/api/startRebilling.md) |
| `stopRebilling` | [View](./docs/api/stopRebilling.md) |
| `createRebillingPayment` | [View](./docs/api/createRebillingPayment.md) |
| `listRebillingStatusChanges` | [View](./docs/api/listRebillingStatusChanges.md) |

### Service Proof
| Endpoint | Documentation |
|----------|---------------|
| `getServiceProofRequest` | [View](./docs/api/getServiceProofRequest.md) |
| `updateServiceProofRequest` | [View](./docs/api/updateServiceProofRequest.md) |
| `listServiceProofRequests` | [View](./docs/api/listServiceProofRequests.md) |

### Shipping
| Endpoint | Documentation |
|----------|---------------|
| `createShippingCostPolicy` | [View](./docs/api/createShippingCostPolicy.md) |
| `getShippingCostPolicy` | [View](./docs/api/getShippingCostPolicy.md) |
| `updateShippingCostPolicy` | [View](./docs/api/updateShippingCostPolicy.md) |
| `deleteShippingCostPolicy` | [View](./docs/api/deleteShippingCostPolicy.md) |
| `listShippingCostPolicies` | [View](./docs/api/listShippingCostPolicies.md) |

### Statistics
| Endpoint | Documentation |
|----------|---------------|
| `statsSales` | [View](./docs/api/statsSales.md) |
| `statsSalesSummary` | [View](./docs/api/statsSalesSummary.md) |
| `statsDailyAmounts` | [View](./docs/api/statsDailyAmounts.md) |
| `statsExpectedPayouts` | [View](./docs/api/statsExpectedPayouts.md) |
| `statsMarketplace` | [View](./docs/api/statsMarketplace.md) |

### Tracking & Conversion
| Endpoint | Documentation |
|----------|---------------|
| `renderJsTrackingCode` | [View](./docs/api/renderJsTrackingCode.md) |
| `listConversionTools` | [View](./docs/api/listConversionTools.md) |

### Transactions
| Endpoint | Documentation |
|----------|---------------|
| `listTransactions` | [View](./docs/api/listTransactions.md) |
| `refundTransaction` | [View](./docs/api/refundTransaction.md) |
| `reportFraud` | [View](./docs/api/reportFraud.md) |

### Upgrades
| Endpoint | Documentation |
|----------|---------------|
| `createUpgrade` | [View](./docs/api/createUpgrade.md) |
| `getUpgrade` | [View](./docs/api/getUpgrade.md) |
| `deleteUpgrade` | [View](./docs/api/deleteUpgrade.md) |
| `listUpgrades` | [View](./docs/api/listUpgrades.md) |
| `getSmartupgrade` | [View](./docs/api/getSmartupgrade.md) |
| `listSmartUpgrades` | [View](./docs/api/listSmartUpgrades.md) |

### Upsells
| Endpoint | Documentation |
|----------|---------------|
| `getUpsells` | [View](./docs/api/getUpsells.md) |
| `updateUpsells` | [View](./docs/api/updateUpsells.md) |
| `deleteUpsells` | [View](./docs/api/deleteUpsells.md) |

### User/API Key Management
| Endpoint | Documentation |
|----------|---------------|
| `requestApiKey` | [View](./docs/api/requestApiKey.md) |
| `retrieveApiKey` | [View](./docs/api/retrieveApiKey.md) |
| `unregister` | [View](./docs/api/unregister.md) |
| `getUserInfo` | [View](./docs/api/getUserInfo.md) |
| `getGlobalSettings` | [View](./docs/api/getGlobalSettings.md) |

### Vouchers/Coupons
| Endpoint | Documentation |
|----------|---------------|
| `createVoucher` | [View](./docs/api/createVoucher.md) |
| `getVoucher` | [View](./docs/api/getVoucher.md) |
| `updateVoucher` | [View](./docs/api/updateVoucher.md) |
| `deleteVoucher` | [View](./docs/api/deleteVoucher.md) |
| `listVouchers` | [View](./docs/api/listVouchers.md) |
| `validateCouponCode` | [View](./docs/api/validateCouponCode.md) |

## Migration

Upgrading from `gosuccess/php-ds24-api-wrapper`? See [MIGRATION.md](docs/MIGRATION.md) for detailed instructions on namespace changes, constructor updates, and breaking changes.

## Testing

The project has comprehensive test coverage with over 1035 tests.

```bash
# Run all tests
composer test

# Run tests with coverage (requires PCOV or Xdebug)
composer test:coverage

# Run mutation testing (validates test quality)
composer mutation

# Run specific test suites
composer test:unit
composer test:integration
```

**Quality Metrics:**
- **Tests**: 1035+ tests
- **Coverage**: Lines ~98%, Functions ~99%, Classes 100%
- **Mutation Score**: 85%+ MSI (test quality indicator)
- **PHPStan**: Level 9 (maximum strictness)

See [TESTING.md](docs/TESTING.md) for detailed testing guide, coverage setup, mutation testing, and best practices.

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## Contributing

Contributions are welcome! Please read our documentation:

- **[Contributing Guidelines](CONTRIBUTING.md)** - Coding standards and pull request process
- **[Developer Setup](docs/DEVELOPER_SETUP.md)** - Complete IDE setup, PHP 8.4 configuration, and development workflow

### Quick Start for Contributors

```bash
# Clone repository
git clone https://github.com/GoSuccessHQ/digistore24-api.git
cd digistore24-api

# Install dependencies (requires PHP 8.4+)
composer install

# Verify setup
php -v  # Should show PHP 8.4.x

# Run tests
composer test

# Check code quality
composer cs:fix
composer analyse
```

See [DEVELOPER_SETUP.md](docs/DEVELOPER_SETUP.md) for detailed IDE setup instructions.

## Support

- **Documentation**: Check the `docs/` directory for endpoint-specific guides
- **Testing Guide**: See [TESTING.md](docs/TESTING.md) for test setup and coverage
- **Issues**: Report bugs on [GitHub Issues](https://github.com/GoSuccessHQ/digistore24-api/issues)
- **Security**: Report security vulnerabilities via [SECURITY.md](SECURITY.md)
- **Migration Guide**: See [MIGRATION.md](docs/MIGRATION.md) for upgrading from v1.x
- **Changelog**: See [CHANGELOG.md](docs/CHANGELOG.md) for version history
