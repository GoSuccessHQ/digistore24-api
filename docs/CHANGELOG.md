# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [3.0.0] - 2026-06-18

Major release that turns the SDK into a complete, fully-typed binding to the
Digistore24 API and removes long-standing inconsistencies. See `MIGRATION.md`
for upgrade steps. Many "breaking" changes touch response fields and request
parameters that were previously wrong, missing, or entirely broken.

### Added
- **Complete, fully-typed binding to the whole API.** Every response now exposes
  every API field as a typed property -- with nested DTOs for objects such as the
  buyer, line items, and transactions -- plus a `data` array holding the full
  payload so no field is ever lost. Every request exposes a settable property for
  every OpenAPI spec parameter. Derived from the per-endpoint specs and verified
  live against a real order. Adds 41 DTOs and 14 enums.
- `SpecConformanceTest` that freezes the spec's endpoint -> HTTP method mapping
  (122 endpoints) and guards against future drift.
- `DeliveryTrackingUpdateData` DTO and `DeliveryTrackingOperation` enum for sending
  shipment tracking via `updateDelivery`.
- `ProductApprovalStatus` and `ProductBuyerType` enums with exactly the values that
  `createProduct`/`updateProduct` accept.

### Changed
- Request HTTP methods now match the spec: read/list/validate/stats endpoints use
  GET, update endpoints use PUT, and delete endpoints use DELETE (previously almost
  every request defaulted to POST). Public method signatures are unchanged.
- `refundPartially` now lives on `PurchaseResource` (`$ds24->purchases->refundPartially()`)
  instead of `BillingResource`; the spec tags this endpoint under Purchases.
- `validateCouponCode` and `getMarketplaceEntry` responses expose typed properties
  instead of a raw `array $data`.
- Request validation now runs inside `execute()`; an invalid request throws a
  `ValidationException` (HTTP 400, exposing `getErrors()`) before any HTTP call.
- Replaced 385 self-referential `get`-only property hooks in Response classes with
  plain defaulted properties (no behavior change, ~546 fewer lines).

### Fixed
- `updateBuyer` sends flat address fields (`street_name`, `city`, ...) instead of a
  non-spec `address` array, and now also supports `salutation`, `title`, `company`,
  `phone_number`, `state`, and `zipcode`.
- `updateDelivery` nests its status fields in a `data` object, supports a `tracking`
  array, and exposes `notify_via_email`.
- `VoucherData` no longer leaks the response-only `id` or the non-spec `valid_until`
  alias into create/update requests.
- `ShippingCostPolicyData` emits language-suffixed labels (`label_en`, `label_de`)
  instead of the literal key `label_XX`.
- `createEticket` sends the buyer salutation as a lowercase `m`/`f` value (as the
  endpoint requires) instead of the enum object.
- Entity create/update endpoints (`createProductGroup`, `createOrderform`, `createVoucher`,
  `createShippingCostPolicy`, `updateProductGroup`, `updateOrderform`, `updatePaymentplan`,
  `updateShippingCostPolicy`) nest their fields under the `data` object the API requires.
  When sent flat, the API either silently ignored them (e.g. `updateOrderform` returned
  `modified:N`) or rejected the call with `Parameter fehlt: data[...]`. Verified live.
- `createPaymentplan` now sends the required `product_id` (flat) alongside the `data` object.
- `updateShippingCostPolicy`, `deleteShippingCostPolicy`, and `getShippingCostPolicy` use the
  API's `policy_id` parameter (was `shipping_cost_policy_id`); `updateServiceProofRequest` uses
  `service_proof_id` (was `service_proof_request_id`).
- DTO response parsing (`AbstractDataTransferObject::fromArray()`) no longer throws when the API
  returns a value that a strict input-validation setter would reject (e.g. `getVoucher`'s
  `valid_from`, a buyer email). The validating set hooks are bypassed via `setRawValue()` when
  deserializing trusted API data; validation still runs on direct user assignment.
- Ten response parsers (`createOrderform`, `createUpgrade`, `getOrderform`, `getUpgrade`,
  `refundPurchase`, `getPurchaseTracking`, `listPurchasesOfEmail`, and others) no longer unwrap
  the `data` envelope a second time, which had made them expose an empty result. They now use
  the inherited `extractInnerData()` helper.
- Many response classes mapped wrong or invented field names and surfaced only a
  fraction of the API's fields: `getPurchase` read `purchase_id` where the API returns
  `id` and flattened the buyer/items; `getImage`, `getProduct`, `statsSales`,
  `statsDailyAmounts`, `statsAffiliateToplist`, and `getGlobalSettings` used keys that
  do not exist. All are now mapped to the real keys and expose the complete field set.
- Six update endpoints (`updateProduct`, `updateVoucher`, `updateBuyer`, `updateUpsells`,
  `updateAffiliateCommission`, `updatePurchase`) sent their fields flat where the API
  requires them nested under a `data` object (the id stays flat). Sent flat the update was
  silently accepted but had no effect (the API returned `modified:N`). Now wrapped
  correctly; verified live. The request constructors are unchanged, so calling code keeps
  working -- updates simply take effect now.
- The product endpoints (`createProduct`, `updateProduct`, `copyProduct`) only modeled
  three languages (de/en/es) for their multilingual fields, but the API accepts and
  returns nine (de, en, es, fr, pt, pl, it, nl, sl). The missing six are now settable for
  `name`, `description`, `description_thankyou_page`, `access_instructions`, and
  `optin_text`, and `GetProductResponse` exposes the previously-missing
  `access_instructions_*` in all nine languages. Verified live.

### Removed
- `BillingResource::refundPartially()` and the duplicate
  `Request/Response\Billing\RefundPartially*` classes (use
  `PurchaseResource::refundPartially()`).
- `ShippingCostPolicyData::$labelXX` (replaced by the `$labels` map).
- The non-spec `reason` parameter from `RefundPartiallyRequest`.
- Generated `openapi.yaml` specification file. The canonical OpenAPI spec is hosted by
  Digistore24 at https://digistore24.com/api/docs/openapi.yaml (per-endpoint files at
  `https://digistore24.com/api/docs/paths/<operationId>.yaml`) and is already referenced from
  the `@link` PHPDoc annotations and the `docs/api/` files.
- `scripts/` directory (`fetch-openapi.php`, `analyze-dtos.php`, `dto-analysis.json`).
  These were development-only helpers, excluded from the dist package via `export-ignore`, and
  partly outdated — `analyze-dtos.php` targeted the removed `src/DataTransferObject` directory
  and a non-existent `generate-dtos.php`.
- Obsolete `export-ignore` rules for `scripts`, `openapi.yaml`, and `.openapi-cache` in
  `.gitattributes`, the `.openapi-cache/` entry in `.gitignore`, and the `scripts/**` path
  filter in the Code Style GitHub Actions workflow.

### Breaking Changes
- `CreateProductRequest`/`UpdateProductRequest` accept `ProductApprovalStatus`/`ProductBuyerType`
  instead of `AffiliateApprovalStatus`/`BuyerType`.
- `UpdateBuyerRequest` no longer accepts an `$address` array; pass the individual address fields.
- `UpdateDeliveryRequest::toArray()` nests the delivery status under a `data` key.
- `ShippingCostPolicyData::$labelXX` is replaced by an `array $labels` keyed by language code.
- `ValidateCouponCodeResponse`/`GetMarketplaceEntryResponse` no longer expose a `$data` array.
- `refundPartially` moved from `$ds24->billing` to `$ds24->purchases`.
- A request that fails its own validation rules now throws a `ValidationException`.
- The spec-aligned HTTP methods may change wire behavior for code that relied on the old all-POST behavior.
- `CreatePaymentplanRequest` now takes a `$productId` argument before `$paymentPlan`; the
  `createPaymentplan` endpoint requires a flat `product_id` in addition to the `data` object.
- The fully-typed binding changed several request constructors to the real API parameters:
  e.g. `UpdateAffiliateCommissionRequest` takes `productIds` (string) not `productId` (int);
  `GetEticketRequest`/`ValidateEticketRequest` use `eticketId`; the service-proof requests use
  `serviceProofId` (int); `ListAccountAccessRequest` is parameterless; `ListPaymentPlansRequest`
  requires a `productId`; several list endpoints (eticket, service-proof, delivery) now take a
  search DTO. See MIGRATION.md.
- Some response property names changed where the SDK previously used wrong keys -- e.g.
  `GetPurchaseResponse` no longer exposes `productId`/`buyerEmail`; read `$response->buyer->email`
  and `$response->items[0]->productId`, or the full `$response->data` payload.

## [2.0.6] - 2025-11-14

### Fixed
- `validateAffiliate` request: corrected the parameter names and HTTP method.

## [2.0.5] - 2025-11-12

### Fixed
- IpnSetupResponse structure now matches actual Digistore24 API response
  - Changed `created`, `updated`, `deleted` from string to bool (Y/N conversion via TypeConverter)
  - Added `domainId`, `shaPassphrase`, `ipnConfigId`, `ipnId` properties

### Breaking Changes
- IpnSetupResponse: Properties `created`, `updated`, `deleted` are now bool instead of string

## [2.0.4] - 2025-11-10

### Fixed
- Added Content-Length: 0 header for POST requests with empty body

## [2.0.3] - 2025-11-09

### Fixed
- UnregisterResponse now uses bool type with TypeConverter for proper type conversion

## [2.0.2] - 2025-11-09

### Added
- DELIVERY permission level to ApiPermission enum

## [2.0.1] - 2025-11-08

### Added
- Complete IPN and List Request classes with type-safe Enums and DTOs

### Changed
- Consolidated DTOs into DTO directory for better organization

## [2.0.0] - 2025-11-08

### Added
- GitHub Actions CI/CD pipeline with automated testing, static analysis, and code style checks
- docs/CHANGELOG.md with complete version history from git tags
- CONTRIBUTING.md with comprehensive contribution guidelines
- SECURITY.md with vulnerability reporting and security best practices
- Issue and Pull Request templates for GitHub
- Dependabot configuration (weekly Composer, monthly GitHub Actions updates)
- PHPStan ^2.1 Level 9 static analysis with baseline (1025 errors tracked)
- PHP CS Fixer ^3.88 with PSR-12 and PHP 8.4 rules
- Complete API endpoints documentation (122 endpoints organized in 29 categories)
- docs/MIGRATION.md with detailed upgrade instructions from v1.x
- 15 typed Data Transfer Objects (DTOs) with PHP 8.4 property hooks
- OpenAPI specification fetcher script for API documentation
- README badges for Tests, PHPStan Level 9, and PSR-12 Code Style
- Optional Request parameters for 27 Resources (39+ methods) - allows cleaner API calls without explicit Request objects

### Changed
- **BREAKING**: Namespace changed from `GoSuccess\Digistore24\` to `GoSuccess\Digistore24\Api\`
- **BREAKING**: Constructor signature changed to use Configuration object instead of direct parameters
- **BREAKING**: Minimum PHP version increased to 8.4 (required for property hooks)
- Enforced single class per file standard (extracted helper classes)
- Replaced FQCNs with import statements throughout codebase (591 files auto-formatted)
- Migrated 14 Request classes from array data to typed DTOs
- Consolidated documentation (merged ARCHITECTURE.md into README.md)
- Updated examples to use typed DTOs (UrlsData, SettingsData)
- Extended .gitattributes with export-ignore rules for smaller dist packages
- API simplification: Methods with all-optional parameters now accept optional Request objects
  - Example: `$ds24->products->list()` instead of `$ds24->products->list(new ListProductsRequest())`
  - Backward compatible: explicit Request objects still work
- User-Agent updated to "GoSuccess-Digistore24-API-Client/2.0 (https://github.com/GoSuccessHQ/digistore24-api)"
- API version corrected to 1.2 (matching actual Digistore24 API)

### Removed
- Legacy directories (src-legacy/, docs-legacy/) - preserved in git history
- Redundant documentation files (IMPLEMENTATION_ROADMAP.md, PHP84-REQUIRED.md)
- PHPUnit generated files from repository (added to .gitignore)

### Fixed
- PHPUnit 11 deprecation warnings (replaced @covers with CoversClass attribute)
- Endpoint path conventions (consistent leading slash usage)
- Nested data structure handling in Response fromArray methods
- AbstractResponse rawResponse property initialization
- Code style compliance (0 PSR-12 violations across 591 files)

### Infrastructure
- 3 GitHub Actions workflows: tests, static-analysis, code-style
- Composer scripts: test, test:coverage, test:unit, test:integration, analyse, cs:check, cs:fix, check
- PHPStan baseline for incremental type safety improvements
- Automated dependency updates via Dependabot

## [1.4.0] - 2024-10-10

### Added
- Complete endpoint documentation for all 122 API endpoints
- Comprehensive PHPDoc comments to all Resource files (36 files)
- PHPDoc documentation to all Request files (122 files)
- @param annotations for better IDE support

### Changed
- Improved documentation structure and consistency
- Updated roadmap to reflect 100% completion status

### Fixed
- Deprecated @covers annotations replaced with #[CoversClass] attributes
- Response tests with proper test data and rawResponse property access
- Nested object initialization in AccountAccess and Eticket responses

## [1.3.0] - 2024-09-15

### Added
- Additional endpoint implementations
- Enhanced test coverage

## [1.2.0] - 2024-08-20

### Added
- Extended API endpoint support
- Improved error handling

## [1.1.1] - 2024-07-30

### Fixed
- Minor bug fixes and improvements

## [1.1.0] - 2024-07-15

### Added
- `listCountries` endpoint implementation

### Changed
- Updated CountryController

### Removed
- Removed error_log statements

## [1.0.0] - 2024-06-01

### Added
- Initial release of Digistore24 API Client
- PHP 8.4 support with property hooks
- Resource-based architecture
- Type-safe requests and responses
- Automatic retry with exponential backoff
- Rate limiting support
- Comprehensive exception handling
- Basic endpoint implementations

### Project Information
- **Package Name**: gosuccess/digistore24-api
- **License**: MIT
- **PHP Version**: >=8.4.0
- **Repository**: https://github.com/GoSuccessHQ/digistore24-api

---

## Version History Summary

| Version | Release Date | Major Changes |
|---------|--------------|---------------|
| [2.0.0] | 2025-10-XX | Breaking changes, CI/CD, code quality tools, DTOs |
| [1.4.0] | 2024-10-10 | Complete documentation, PHPDoc coverage |
| [1.3.0] | 2024-09-15 | Additional endpoints |
| [1.2.0] | 2024-08-20 | Extended API support |
| [1.1.1] | 2024-07-30 | Bug fixes |
| [1.1.0] | 2024-07-15 | Country listing support |
| [1.0.0] | 2024-06-01 | Initial release |

## Migration Guides

- **v1.x to v2.x**: See [MIGRATION.md](MIGRATION.md) for detailed upgrade instructions
  - Namespace changes: `GoSuccess\Digistore24\` → `GoSuccess\Digistore24\Api\`
  - Constructor changes: Direct parameters → Configuration object
  - PHP 8.4 required for property hooks

## Links

- [GitHub Repository](https://github.com/GoSuccessHQ/digistore24-api)
- [Issue Tracker](https://github.com/GoSuccessHQ/digistore24-api/issues)
