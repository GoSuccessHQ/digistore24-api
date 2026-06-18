# Contributing to Digistore24 API Client

Thank you for considering contributing to the Digistore24 API Client! This document provides guidelines and instructions for contributing.

## Table of Contents

- [Code of Conduct](#code-of-conduct)
- [Getting Started](#getting-started)
- [Development Setup](#development-setup)
- [Coding Standards](#coding-standards)
- [Project Structure](#project-structure)
- [Making Changes](#making-changes)
- [Testing](#testing)
- [Submitting Changes](#submitting-changes)
- [Documentation](#documentation)

## Code of Conduct

This project follows a professional code of conduct. Be respectful, constructive, and collaborative in all interactions.

## Getting Started

1. **Fork the repository** on GitHub
2. **Clone your fork** locally:
   ```bash
   git clone https://github.com/YOUR-USERNAME/digistore24-api.git
   cd digistore24-api
   ```
3. **Add upstream remote**:
   ```bash
   git remote add upstream https://github.com/GoSuccessHQ/digistore24-api.git
   ```

## Development Setup

### Requirements

- **PHP 8.4.0 or higher** (required for property hooks)
- Composer
- Git

### Installation

```bash
# Install dependencies
composer install

# Run tests to verify setup
composer test
```

## Coding Standards

### PHP Version

This project **requires PHP 8.4+** and uses modern features:
- ✅ Property hooks for validation
- ✅ Typed properties
- ✅ Constructor property promotion
- ✅ Enums
- ✅ Match expressions

### Code Style

#### 1. Property Hooks Over Constructors

**Preferred:**
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
}
```

**Avoid:**
```php
final class BuyerData
{
    public function __construct(
        private string $email
    ) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException("Invalid email");
        }
    }
}
```

#### 2. Use Imports, Not FQCNs

**Preferred:**
```php
use GoSuccess\Digistore24\Api\Http\Response;

public ?Response $response = null;
```

**Avoid:**
```php
public ?\GoSuccess\Digistore24\Api\Http\Response $response = null;
```

#### 3. Single Class Per File

Each class, interface, or enum must be in its own file. Helper classes should be extracted:

**Preferred:**
```
src/Response/Eticket/EticketDetail.php       # Helper class
src/Response/Eticket/GetEticketResponse.php  # Main response
```

**Avoid:**
```php
// Both in GetEticketResponse.php
final class GetEticketResponse { }
final class EticketDetail { }  // ❌ Extract to own file
```

#### 4. Naming Conventions

- **Directories**: Singular form (`Exception/`, `Request/`, `Response/`)
- **Classes**: PascalCase (`CreateBuyUrlRequest`, `BuyerData`)
- **Methods**: camelCase (`getCommission()`, `createBuyUrl()`)
- **Properties**: camelCase (`$firstName`, `$productId`)
- **Constants**: PascalCase in enums (`Method::Get`, `StatusCode::Ok`)

#### 5. String Interpolation

**Preferred:**
```php
echo "Buy URL: {$response->url}\n";
throw new ApiException("Invalid status: {$status}");
```

**Avoid:**
```php
echo "Buy URL: " . $response->url . "\n";
throw new ApiException("Invalid status: " . $status);
```

#### 6. Type Declarations

Always use strict types and full type hints:

```php
declare(strict_types=1);

final class Example
{
    public function process(int $id, ?string $name = null): bool
    {
        // ...
    }
}
```

#### 7. Final Classes

Make classes `final` unless they're explicitly designed for inheritance:

```php
final class BuyerData { }          // ✅ Preferred
abstract class AbstractRequest { } // ✅ OK for base classes
class SomeData { }                 // ❌ Add final
```

## Project Structure

```
src/
├── Base/                    # Abstract base classes
├── Client/                  # HTTP client implementation
├── Contract/                # Interfaces
├── DTO/                     # DTOs with property hooks
├── Enum/                    # Backed enums
├── Exception/               # Exception hierarchy
├── Http/                    # HTTP-related classes
├── Request/                 # API request classes
├── Resource/                # Resource classes (37 resources)
├── Response/                # API response classes
├── Trait/                   # Shared traits
└── Util/                    # Utility classes
```

### Adding New Features

#### New DTO (Data Transfer Object)

1. Create in `src/DTO/`
2. Use property hooks for validation
3. Make class `final`
4. Add comprehensive PHPDoc

```php
declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\DTO;

/**
 * Buyer information for API requests.
 */
final class BuyerData
{
    public string $email {
        set {
            if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                throw new \InvalidArgumentException("Invalid email format");
            }
            $this->email = $value;
        }
    }

    public ?string $firstName = null;
    public ?string $lastName = null;
}
```

#### New Request Class

1. Create in appropriate `src/Request/*/` subdirectory
2. Extend `AbstractRequest`
3. Use DTOs instead of arrays
4. Document all properties

```php
declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Request\BuyUrl;

use GoSuccess\Digistore24\Api\Base\AbstractRequest;
use GoSuccess\Digistore24\Api\DTO\BuyerData;

/**
 * Create a new buy URL.
 */
final class CreateBuyUrlRequest extends AbstractRequest
{
    public int $productId;
    public ?string $validUntil = null;
    public ?BuyerData $buyer = null;

    public function getEndpoint(): string
    {
        return '/createBuyUrl';
    }
}
```

#### New Response Class

1. Create in appropriate `src/Response/*/` subdirectory
2. Extend `AbstractResponse`
3. Extract helper classes to separate files

```php
declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Response\BuyUrl;

use GoSuccess\Digistore24\Api\Base\AbstractResponse;

/**
 * Response from createBuyUrl endpoint.
 */
final class CreateBuyUrlResponse extends AbstractResponse
{
    public string $url;
    public ?string $buyUrlId = null;
}
```

## Testing

### Running Tests

```bash
# Run all tests
composer test

# Run with coverage
composer test:coverage

# Run specific test file
./vendor/bin/phpunit tests/Unit/DataTransferObject/BuyerDataTest.php
```

### Writing Tests

Every new feature must include tests:

```php
declare(strict_types=1);

namespace GoSuccess\Digistore24\Api\Tests\Unit\DataTransferObject;

use GoSuccess\Digistore24\Api\DTO\BuyerData;
use PHPUnit\Framework\TestCase;

final class BuyerDataTest extends TestCase
{
    public function testEmailValidationAcceptsValidEmail(): void
    {
        $buyer = new BuyerData();
        $buyer->email = 'test@example.com';

        $this->assertSame('test@example.com', $buyer->email);
    }

    public function testEmailValidationRejectsInvalidEmail(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $buyer = new BuyerData();
        $buyer->email = 'invalid-email';
    }
}
```

### Test Coverage

- Aim for **90%+ code coverage**
- All DTOs must have validation tests
- All Request/Response classes must have unit tests
- Integration tests for complete workflows

## Making Changes

### Branch Naming

- `feature/add-voucher-dto` - New features
- `fix/email-validation` - Bug fixes
- `docs/update-readme` - Documentation
- `refactor/extract-helper-class` - Code refactoring

### Commit Messages

Follow conventional commit format:

```
type: Short description (max 72 chars)

- Detailed bullet point 1
- Detailed bullet point 2
- Reference to issue if applicable
```

**Types:**
- `feat:` New feature
- `fix:` Bug fix
- `docs:` Documentation changes
- `refactor:` Code refactoring
- `test:` Adding or updating tests
- `chore:` Maintenance tasks

**Examples:**
```bash
git commit -m "feat: Add VoucherData DTO with validation" \
           -m "- Implement property hooks for code, discount, validity" \
           -m "- Add comprehensive unit tests" \
           -m "- Update documentation"

git commit -m "fix: Correct email validation in BuyerData" \
           -m "- Use filter_var with FILTER_VALIDATE_EMAIL" \
           -m "- Add test for edge cases" \
           -m "- Fixes #123"
```

### Keeping Your Fork Updated

```bash
# Fetch upstream changes
git fetch upstream

# Merge into your main branch
git checkout main
git merge upstream/main

# Rebase your feature branch
git checkout feature/your-feature
git rebase main
```

## Submitting Changes

### Pull Request Process

1. **Update your branch** with latest upstream changes
2. **Run tests** and ensure they pass:
   ```bash
   composer test
   ```
3. **Update documentation** if needed
4. **Push to your fork**:
   ```bash
   git push origin feature/your-feature
   ```
5. **Create Pull Request** on GitHub

### Pull Request Checklist

- [ ] Tests pass locally (`composer test`)
- [ ] Code follows style guidelines
- [ ] One class per file
- [ ] Imports instead of FQCNs
- [ ] Property hooks used where applicable
- [ ] Comprehensive PHPDoc comments
- [ ] New features have tests
- [ ] Documentation updated
- [ ] Commit messages follow conventions
- [ ] No merge conflicts with main branch

### Pull Request Template

```markdown
## Description
Brief description of changes

## Type of Change
- [ ] Bug fix
- [ ] New feature
- [ ] Breaking change
- [ ] Documentation update

## Testing
How has this been tested?

## Checklist
- [ ] Tests pass
- [ ] Code follows style guide
- [ ] Documentation updated
- [ ] Commits follow conventions
```

## Documentation

### Code Documentation

Use comprehensive PHPDoc:

```php
/**
 * Create a new buy URL for a product.
 *
 * @param CreateBuyUrlRequest $request The request with product ID and options
 * @return CreateBuyUrlResponse The response with generated URL
 * @throws AuthenticationException If API key is invalid
 * @throws ValidationException If request data is invalid
 * @throws ApiException For other API errors
 */
public function create(CreateBuyUrlRequest $request): CreateBuyUrlResponse
{
    // ...
}
```

### Endpoint Documentation

When adding a new endpoint, create documentation in `docs/`:

```markdown
# endpointName

Brief description of what this endpoint does.

## Endpoint

\`\`\`
POST /endpointName
\`\`\`

## Request Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `param1` | string | Yes | Description |
| `param2` | int | No | Description |

## Response

\`\`\`php
[
    'result' => 'success',
    'data' => [
        'field1' => 'value',
        'field2' => 123
    ]
]
\`\`\`

## Usage Example

\`\`\`php
use GoSuccess\Digistore24\Api\Digistore24;

$api = new Digistore24($config);
$response = $api->resource->method($request);
\`\`\`

## Error Responses

| Code | Message | Description |
|------|---------|-------------|
| 400 | Bad Request | Invalid parameters |
| 404 | Not Found | Resource not found |
```

## Questions?

- Open an issue for bugs or feature requests
- Check existing issues before creating new ones
- Be clear and provide examples

## License

By contributing, you agree that your contributions will be licensed under the MIT License.

---

Thank you for contributing to the Digistore24 API Client! 🎉
