# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

### Removed
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
- [Contributing Guidelines](CONTRIBUTING.md)
