# Testing Guide

This document describes the testing strategy and setup for the Digistore24 API Client.

## Table of Contents

- [Overview](#overview)
- [Test Types](#test-types)
- [Running Tests](#running-tests)
- [Code Coverage](#code-coverage)
- [Mutation Testing](#mutation-testing)
- [Integration Tests](#integration-tests)
- [Writing Tests](#writing-tests)
- [Continuous Integration](#continuous-integration)

## Overview

The project uses **PHPUnit 11.x** for testing with a comprehensive test suite covering:

- **Unit Tests**: 1035+ tests testing individual components
- **Integration Tests**: Tests with mocked HTTP responses
- **Code Coverage**: Tracking test coverage metrics
- **Mutation Testing**: Infection PHP for test quality validation
- **Static Analysis**: PHPStan Level 9 for type safety

### Current Test Statistics

- **Tests**: 1213 tests
- **Assertions**: 3462 assertions
- **PHPStan Level**: 9 (maximum)

## Test Types

### Unit Tests (`tests/Unit/`)

Test individual classes and methods in isolation:

```php
<?php

namespace GoSuccess\Digistore24\Api\Tests\Unit\Request;

use GoSuccess\Digistore24\Api\Request\BuyUrl\CreateBuyUrlRequest;
use PHPUnit\Framework\TestCase;

class CreateBuyUrlRequestTest extends TestCase
{
    public function testCanSetProductId(): void
    {
        $request = new CreateBuyUrlRequest();
        $request->productId = 12345;

        $this->assertSame(12345, $request->productId);
    }
}
```

### Integration Tests (`tests/Integration/`)

Test complete workflows with mocked HTTP responses:

```php
<?php

namespace GoSuccess\Digistore24\Api\Tests\Integration;

use GoSuccess\Digistore24\Api\Digistore24;
use GoSuccess\Digistore24\Api\Client\Configuration;
use PHPUnit\Framework\TestCase;

class BuyUrlWorkflowTest extends TestCase
{
    public function testCreateAndListBuyUrls(): void
    {
        $config = new Configuration(apiKey: 'test-key');
        $client = new Digistore24($config);

        // Mock HTTP client responses
        // Test complete workflow
    }
}
```

## Running Tests

### All Tests

```bash
# Run all tests (fast, no coverage)
composer test

# Run all tests with coverage (requires Xdebug/PCOV)
composer test:coverage
```

### Specific Test Suites

```bash
# Run only unit tests
composer test:unit

# Run only integration tests
composer test:integration

# Run specific test file
vendor/bin/phpunit tests/Unit/Client/ConfigurationTest.php

# Run specific test method
vendor/bin/phpunit --filter testCanCreateConfiguration
```

### Test Options

```bash
# Run with verbose output
vendor/bin/phpunit --testdox

# Stop on first failure
vendor/bin/phpunit --stop-on-failure

# Run tests in random order
vendor/bin/phpunit --order-by=random
```

## Code Coverage

### Prerequisites

To generate code coverage reports, you need either **Xdebug** or **PCOV** installed.

#### Install PCOV (Recommended - Faster)

**Windows (Laragon/XAMPP):**
1. Download PCOV from [PECL](https://pecl.php.net/package/pcov)
2. Extract `php_pcov.dll` to `C:\laragon\bin\php\php-8.4.x\ext\`
3. Add to `php.ini`:
   ```ini
   [pcov]
   extension=pcov
   pcov.enabled=1
   pcov.directory=.
   ```
4. Restart PHP: `php -m | grep pcov`

**macOS/Linux:**
```bash
pecl install pcov
echo "extension=pcov.so" >> $(php --ini | grep "Loaded Configuration" | sed -e "s|.*:\s*||")
```

#### Install Xdebug (Alternative)

**Windows:**
1. Download from [Xdebug.org](https://xdebug.org/download)
2. Follow installation wizard instructions
3. Add to `php.ini`:
   ```ini
   [xdebug]
   zend_extension=xdebug
   xdebug.mode=coverage
   ```

**macOS/Linux:**
```bash
pecl install xdebug
echo "zend_extension=xdebug.so" >> $(php --ini | grep "Loaded Configuration" | sed -e "s|.*:\s*||")
echo "xdebug.mode=coverage" >> $(php --ini | grep "Loaded Configuration" | sed -e "s|.*:\s*||")
```

### Generate Coverage Reports

```bash
# HTML report (opens in browser)
composer test:coverage

# Text report in terminal
vendor/bin/phpunit --coverage-text

# XML report (for CI/CD)
vendor/bin/phpunit --coverage-clover coverage.xml

# All formats
vendor/bin/phpunit --coverage-html build/coverage \
                   --coverage-clover build/logs/clover.xml \
                   --coverage-text
```

### Coverage Reports Location

After running `composer test:coverage`:

- **HTML Report**: `build/coverage/index.html` - Open in browser
- **XML Report**: `build/logs/clover.xml` - For CI/CD tools
- **Text Report**: Displayed in terminal

### Coverage Thresholds

The project enforces minimum coverage thresholds in `phpunit.xml`:

```xml
<coverage>
    <report>
        <html outputDirectory="build/coverage"/>
        <clover outputFile="build/logs/clover.xml"/>
    </report>
</coverage>
```

**Current Coverage Targets:**
- Lines: 95%+
- Functions: 98%+
- Classes: 100%

## Mutation Testing

Mutation testing validates the **quality of your tests** by intentionally introducing bugs (mutations) into your code and checking if your tests catch them.

### What is Mutation Testing?

Traditional code coverage only tells you which lines were executed, not if your tests actually validate the behavior. Mutation testing goes further:

1. **Infection** modifies your source code (e.g., changes `*` to `+`, `==` to `!=`)
2. Runs your test suite against the mutated code
3. If tests **fail** → Good! Your tests caught the bug ✓
4. If tests **pass** → Bad! Your tests didn't catch the bug ✗ (escaped mutant)

### Example

```php
// Original code
public function getTotal(): float
{
    return $this->price * $this->quantity;  // Multiplication
}

// Mutation: * changed to +
public function getTotal(): float
{
    return $this->price + $this->quantity;  // Addition (BUG!)
}

// Good test (catches mutation):
$this->assertSame(100.0, $product->getTotal());  // ✓ Fails with mutation

// Bad test (doesn't catch mutation):
$this->assertIsFloat($product->getTotal());  // ✗ Still passes with mutation
```

### Prerequisites

Mutation testing requires **PCOV** or **Xdebug** for code coverage (see [Code Coverage](#code-coverage) section).

```bash
# Verify coverage driver is installed
php -m | grep -E "pcov|xdebug"
```

### Running Mutation Tests

```bash
# Run mutation testing (recommended - shows mutations)
composer mutation

# Run with detailed report
composer mutation:report

# Run only on covered code (faster)
composer mutation:baseline

# Manual execution with custom options
vendor/bin/infection --threads=4 --show-mutations --min-msi=85
```

### Understanding Results

After running `composer mutation`, you'll see output like:

```
735 mutations were generated:
     519 mutants were killed
     189 mutants were not covered by tests
      21 covered mutants were not detected
       6 errors were encountered
       0 syntax errors were encountered
       0 time outs were encountered
       0 mutants required more time than configured

Metrics:
         Mutation Score Indicator (MSI): 87%
         Mutation Code Coverage: 74%
         Covered Code MSI: 96%
```

#### Key Metrics

**1. Mutation Score Indicator (MSI)**
- **What**: Percentage of killed mutants out of all mutants
- **Formula**: (Killed / Total) × 100
- **Target**: 85%+
- **Meaning**: Overall test effectiveness

**2. Mutation Code Coverage**
- **What**: Percentage of mutants covered by tests
- **Formula**: (Covered / Total) × 100
- **Target**: 80%+
- **Meaning**: How much code is reachable by tests

**3. Covered Code MSI**
- **What**: Percentage of killed mutants out of covered mutants
- **Formula**: (Killed / Covered) × 100
- **Target**: 90%+
- **Meaning**: Test quality for covered code

### Mutation Types

Infection applies various mutations (mutators):

```php
// Arithmetic Operators
$a * $b  →  $a + $b   // Multiplication to Addition
$a / $b  →  $a * $b   // Division to Multiplication
$a % $b  →  $a * $b   // Modulus to Multiplication

// Comparison Operators
$a == $b  →  $a != $b   // Equal to Not Equal
$a < $b   →  $a <= $b   // Less Than to Less Or Equal
$a > $b   →  $a >= $b   // Greater Than to Greater Or Equal

// Logical Operators
$a && $b  →  $a || $b   // AND to OR
!$a       →  $a         // NOT removed

// Return Values
return true;   →  return false;
return $value; →  return null;

// Increments
$i++;  →  $i--;
++$i;  →  --$i;

// Array Operations
$array[]  →  array_pop($array)
count($a) →  count($a) + 1

// String Operations
$a . $b  →  $b         // Concatenation removal
trim($s) →  $s         // Function call removal
```

### Configuration

The mutation testing configuration is in `infection.json5`:

```json5
{
    // Minimum thresholds (fail if below)
    "minMsi": 85,        // Minimum Mutation Score Indicator
    "minCoveredMsi": 90, // Minimum Covered Code MSI

    // Mutators to apply
    "mutators": {
        "@default": true,  // All default mutators
        "@function_signature": false  // Disable (too many false positives)
    }
}
```

### Viewing Reports

After running mutation tests, check the generated reports:

```bash
# HTML report (detailed, interactive)
open build/infection/infection.html

# Text log
cat build/infection/infection.log

# Summary
cat build/infection/summary.log

# JSON (for CI/CD)
cat build/infection/infection.json
```

### Improving Mutation Score

If you have escaped mutants (mutants not detected), improve your tests:

**Example: Escaped Mutant**
```
Escaped mutants:
===============

1) src/Util/Validator.php:42    [M] DecrementInteger
-    return count($items) > 0;
+    return count($items) - 1 > 0;
```

**Fix: Add specific assertion**
```php
// Before (weak test)
$this->assertTrue($validator->hasItems());

// After (strong test)
$this->assertTrue($validator->hasItems());
$this->assertSame(3, count($items));  // Catches count mutations
```

### CI/CD Integration

Add to `.github/workflows/mutation-tests.yml`:

```yaml
name: Mutation Tests

on:
  push:
    branches: [main]
  pull_request:
    branches: [main]

jobs:
  mutation:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v4

      - uses: shivammathur/setup-php@v2
        with:
          php-version: '8.4'
          coverage: pcov

      - run: composer install

      - name: Run Mutation Tests
        run: composer mutation:report

      - name: Upload Mutation Report
        uses: actions/upload-artifact@v4
        if: always()
        with:
          name: mutation-report
          path: build/infection/
```

### Best Practices

1. ✅ **Run regularly** - Include in CI/CD pipeline
2. ✅ **Focus on critical code** - Payment, validation, security logic
3. ✅ **Don't aim for 100%** - 85-90% MSI is excellent
4. ✅ **Review escaped mutants** - Learn from them, improve tests
5. ✅ **Use `--only-covered`** - Faster feedback loop during development
6. ✅ **Disable problematic mutators** - If too many false positives
7. ⚠️ **Expect longer runtime** - 10-30 minutes for full run
8. ⚠️ **Not a replacement** - Complement to code coverage, not replacement

### Troubleshooting

**"The process has been signaled with signal '9'"**
```bash
# Increase timeout
vendor/bin/infection --timeout=20
```

**"No mutations generated"**
```bash
# Ensure tests have coverage
composer test:coverage
```

**Too many false positives from specific mutator**
```json5
// infection.json5
"mutators": {
    "@default": true,
    "PregQuote": false,  // Disable specific mutator
    "ArrayItemRemoval": {
        "ignore": [
            "MyClass::myMethod"  // Ignore specific method
        ]
    }
}
```

**Tests are too slow**
```bash
# Use more threads (use CPU core count)
vendor/bin/infection --threads=8

# Run only on changed files
vendor/bin/infection --git-diff-lines --git-diff-base=main
```

## Integration Tests

Integration tests validate the client against the **real Digistore24 API**. Unlike unit tests which use mocks, integration tests make actual HTTP requests.

### ⚠️ IMPORTANT: Cost Warning

**Some endpoints cost REAL MONEY!**

Endpoints like `createBillingOnDemand`, `createRebillingPayment`, `refundPurchase` execute real transactions that:
- Charge real money (min €0.80 per test)
- Create real refunds
- Affect real customer accounts

**Always use TEST data only!**

### Configuration

Integration tests require configuration in `.env.local`:

1. **Copy the example file:**
   ```bash
   cp .env.example .env.local
   ```

2. **Fill in your test data:**
   ```bash
   # .env.local
   DS24_API_KEY=your-api-key-here
   DS24_TEST_PRODUCT_ID=12345
   DS24_TEST_PURCHASE_ID=TESTORDER123
   DS24_TEST_PURCHASE_WITH_REBILLING=REBILL456
   # ... see .env.example for all options
   ```

3. **Use TEST data only:**
   - Test products with €0.01 price
   - Test purchases from test orders
   - Test buyer accounts (not real customers)

### Running Integration Tests

```bash
# Run all integration tests (skips tests with missing config)
composer test:integration

# Run specific test file
vendor/bin/phpunit tests/Integration/BillingIntegrationTest.php

# Run with warnings suppressed
DS24_SUPPRESS_WARNINGS=1 composer test:integration
```

### Test Behavior

**Automatic Skipping:**
- Tests automatically skip if required configuration is missing
- Clear warning message shows which config key is needed
- Summary at end shows all missing configurations

**Example:**
```
⚠️  Required configuration 'DS24_TEST_PRODUCT_ID' is not set
   Please set 'DS24_TEST_PRODUCT_ID' in .env.local or environment variables.
   See .env.example for all available configuration options.

Skipped: 1 test
```

### Configuration Keys

See `.env.example` for complete list. Key configurations:

| Config Key | Purpose | Required For |
|------------|---------|--------------|
| `DS24_API_KEY` | API authentication | All tests |
| `DS24_TEST_PRODUCT_ID` | Product for testing | Product tests |
| `DS24_TEST_PURCHASE_ID` | Purchase for testing | Purchase tests |
| `DS24_TEST_PURCHASE_WITH_REBILLING` | Purchase with rebilling | Billing tests |
| `DS24_TEST_BUYER_EMAIL` | Test buyer email | Buyer tests |

### GitHub Actions

Integration tests can be run manually via GitHub Actions:

1. Go to **Actions** → **Integration Tests**
2. Click **Run workflow**
3. Configure inputs:
   - **Test Product ID**: Your test product ID (optional)
   - **Test Purchase ID**: Your test purchase ID (optional)
   - **Test Buyer Email**: Your test buyer email (optional)
   - etc.
4. Click **Run workflow**

**GitHub Secrets Required:**
- `DS24_API_KEY` - Your Digistore24 API key

**Note:** All test data is provided as workflow inputs, not secrets. This allows you to easily update test data without changing repository secrets.

### Best Practices

1. ✅ **Always use TEST data**
2. ✅ **Create dedicated test products** with €0.01 price
3. ✅ **Use separate test account** for integration testing
4. ✅ **Review all test data** before running tests
5. ✅ **Check `.env.example`** for all required configurations
6. ⚠️ **Never commit `.env.local`** (already in .gitignore)

### Writing Integration Tests

Extend `IntegrationTestCase` for automatic configuration handling:

```php
<?php

namespace GoSuccess\Digistore24\Api\Tests\Integration;

use PHPUnit\Framework\Attributes\Group;

#[Group('integration')]
class MyIntegrationTest extends IntegrationTestCase
{
    public function testSomething(): void
    {
        // Get API key (skips test if not configured)
        $apiKey = $this->getApiKey();

        // Get required config (skips test if missing)
        $productId = $this->requireConfig('DS24_TEST_PRODUCT_ID');

        // Get optional config with default
        $timeout = $this->getConfig('DS24_TIMEOUT', '30');

        // Your test code here...
    }
}
```

## Writing Tests

### Test Structure

Follow PHPUnit best practices:

```php
<?php

namespace GoSuccess\Digistore24\Api\Tests\Unit;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(YourClass::class)]
class YourClassTest extends TestCase
{
    private YourClass $subject;

    protected function setUp(): void
    {
        parent::setUp();
        $this->subject = new YourClass();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
    }

    public function testItDoesSomething(): void
    {
        // Arrange
        $input = 'test';

        // Act
        $result = $this->subject->doSomething($input);

        // Assert
        $this->assertSame('expected', $result);
    }
}
```

### Naming Conventions

- Test classes: `{ClassName}Test.php`
- Test methods: `test{Behavior}()` or `testIt{Does}{Something}()`
- Use descriptive names: `testThrowsExceptionWhenApiKeyIsEmpty()`

### Assertions

Common PHPUnit assertions:

```php
// Equality
$this->assertSame($expected, $actual);      // Strict equality (===)
$this->assertEquals($expected, $actual);    // Loose equality (==)

// Types
$this->assertIsString($value);
$this->assertIsInt($value);
$this->assertInstanceOf(ClassName::class, $object);

// Booleans
$this->assertTrue($condition);
$this->assertFalse($condition);

// Arrays
$this->assertCount(3, $array);
$this->assertContains('item', $array);
$this->assertArrayHasKey('key', $array);

// Exceptions
$this->expectException(ValidationException::class);
$this->expectExceptionMessage('Invalid API key');
```

### Data Providers

Use data providers for multiple test cases:

```php
/**
 * @dataProvider validEmailProvider
 */
public function testValidatesEmails(string $email, bool $expected): void
{
    $result = $this->validator->isValid($email);
    $this->assertSame($expected, $result);
}

public static function validEmailProvider(): array
{
    return [
        ['test@example.com', true],
        ['invalid-email', false],
        ['', false],
    ];
}
```

### Mocking

Use PHPUnit mocks for dependencies:

```php
public function testCallsApiClient(): void
{
    $mockClient = $this->createMock(ApiClient::class);
    $mockClient->expects($this->once())
               ->method('post')
               ->with('/endpoint', ['data' => 'value'])
               ->willReturn(['result' => 'success']);

    $service = new YourService($mockClient);
    $result = $service->doSomething();

    $this->assertSame('success', $result);
}
```

## Continuous Integration

### GitHub Actions

Tests run automatically on every push and pull request:

```yaml
name: Tests
on: [push, pull_request]

jobs:
  test:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v4
      - uses: shivammathur/setup-php@v2
        with:
          php-version: '8.4'
          coverage: pcov
      - run: composer install
      - run: composer test:coverage
```

## Troubleshooting

### Common Issues

**"No code coverage driver available"**
```bash
# Install PCOV or Xdebug
pecl install pcov
php -m | grep pcov
```

**"Class not found"**
```bash
# Regenerate autoloader
composer dump-autoload
```

**"Tests are slow"**
```bash
# Use PCOV instead of Xdebug (5-10x faster)
# Or run without coverage:
composer test
```

**"Memory limit exceeded"**
```bash
# Increase PHP memory limit
php -d memory_limit=512M vendor/bin/phpunit
```

## Best Practices

1. ✅ **Write tests first** (TDD) or alongside feature code
2. ✅ **One assertion per test** (ideally, or related assertions)
3. ✅ **Use descriptive test names** that explain the behavior
4. ✅ **Keep tests simple** - tests shouldn't need tests
5. ✅ **Mock external dependencies** (HTTP, Database, etc.)
6. ✅ **Test edge cases** (null, empty, invalid input)
7. ✅ **Aim for >95% coverage** but focus on meaningful tests
8. ✅ **Run tests before commits** (`composer check`)

## Resources

- [PHPUnit Documentation](https://phpunit.de/documentation.html)
- [PCOV Documentation](https://github.com/krakjoe/pcov)
- [Xdebug Documentation](https://xdebug.org/docs/code_coverage)
- [PHP Testing Best Practices](https://phpunit.de/best-practices.html)
