# Developer Experience Setup

This guide helps you set up your development environment for the best experience when working with this project.

## 📋 Prerequisites

- **PHP 8.4+** (Required)
- **Composer** (Package Manager)
- **Git** (Version Control)

### Verify PHP Version

```bash
php -v
# Should output: PHP 8.4.x or higher
```

If you don't have PHP 8.4, install it:

**Windows (Laragon/XAMPP):**
- Download PHP 8.4 from [windows.php.net](https://windows.php.net/download/)
- Or use [Laragon](https://laragon.org/) which includes PHP 8.4

**macOS (Homebrew):**
```bash
brew install php@8.4
brew link php@8.4
```

**Linux (Ubuntu/Debian):**
```bash
sudo add-apt-repository ppa:ondrej/php
sudo apt update
sudo apt install php8.4-cli php8.4-curl php8.4-mbstring
```

## 🔧 IDE Setup

### Visual Studio Code (Recommended)

#### 1. Install Recommended Extensions

   When you open the project, VS Code will prompt you to install recommended extensions. Accept the prompt or install manually:

   - **Intelephense** - PHP IntelliSense
   - **PHP Debug** - XDebug integration
   - **EditorConfig** - Consistent editor settings
   - **PHP CS Fixer** - Code formatting
   - **PHPStan** - Static analysis
   - **PHP DocBlocker** - Auto-generate PHPDoc comments
   - **PHP Namespace Resolver** - Import classes
   - **PHPUnit Test Explorer** - Run tests in sidebar

#### 2. Configure PHP 8.4 Path

Since this project requires PHP 8.4+, you need to configure VS Code to use the correct PHP version.

**Option 1: User Settings (Recommended for all projects)**

1. Press `Ctrl+Shift+P` (Windows/Linux) or `Cmd+Shift+P` (macOS)
2. Type "Preferences: Open User Settings (JSON)"
3. Add your PHP 8.4 path:

```json
{
    "php.validate.executablePath": "/path/to/php8.4"
}
```

**Common PHP Paths:**
- **Laragon (Windows)**: `"C:/laragon/bin/php/php-8.4.12-nts-Win32-vs17-x64/php.exe"`
- **XAMPP (Windows)**: `"C:/xampp/php/php.exe"`
- **Homebrew (macOS)**: `"/opt/homebrew/bin/php"`
- **Linux**: `"/usr/bin/php"`

**Option 2: Workspace Settings (Project-specific)**

```bash
# Copy the example file
cp .vscode/settings.local.json.example .vscode/settings.local.json

# Edit .vscode/settings.local.json with your PHP paths
```

This file is ignored by git, so your local paths won't be committed.

**Option 3: System PATH**

Ensure PHP 8.4 is in your system PATH and VS Code will use it automatically.

#### 3. Settings are Pre-configured

   The `.vscode/settings.json` file contains:
   - Format on save with PHP CS Fixer
   - PHPStan integration
   - 120 character line limit
   - 4-space indentation
   - LF line endings

#### 4. Debugging Setup

   XDebug configuration is ready in `.vscode/launch.json`. Install XDebug and you can:
   - Set breakpoints
   - Step through code
   - Inspect variables

   Press `F5` to start debugging.

## 🎨 EditorConfig

The `.editorconfig` file ensures consistent formatting across all editors:

```ini
[*.php]
indent_style = space
indent_size = 4
max_line_length = 120
charset = utf-8
end_of_line = lf
insert_final_newline = true
trim_trailing_whitespace = true
```

Most modern editors support EditorConfig automatically.

## 🧪 Running Tests

### Command Line
```bash
# Run all tests
composer test

# Run specific test suite
composer test:unit
composer test:integration

# Run with coverage (slower)
composer test:coverage

# Run specific test file
vendor/bin/phpunit tests/Unit/Http/ResponseTest.php
```

### VS Code
- Use the **Testing** sidebar (Flask icon)
- Run/debug individual tests with CodeLens buttons above test methods
- View test results inline

## 🔍 Code Quality Checks

### Before Committing

```bash
# Fix code style automatically
composer cs:fix

# Check for issues without fixing
composer cs:check

# Run static analysis
composer analyse

# Run all checks
composer check
```

### Continuous Integration

All checks run automatically on GitHub Actions:
- ✅ PHP CS Fixer (PSR-12 compliance)
- ✅ PHPStan Level Max (static analysis)
- ✅ PHPUnit (all test suites)
- ✅ Code coverage reporting

## 📝 Writing Code

### PHP 8.4 Features

This project uses modern PHP 8.4 features:

```php
// ✅ Property Hooks (instead of getters/setters)
public string $email {
    set {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException('Invalid email');
        }
        $this->email = $value;
    }
}

// ✅ Typed Properties
public readonly int $statusCode;

// ✅ Constructor Property Promotion
public function __construct(
    private readonly Configuration $config,
) {}

// ✅ Enums
enum HttpMethod: string {
    case GET = 'GET';
    case POST = 'POST';
}

// ✅ Match Expressions
return match ($statusCode) {
    HttpStatusCode::OK => 'Success',
    HttpStatusCode::NOT_FOUND => 'Not Found',
    default => 'Unknown',
};
```

### Type Hints

**Always use type hints:**

```php
// ✅ Good
public function getProduct(int $productId): ProductResponse
{
    // ...
}

// ❌ Bad
public function getProduct($productId)
{
    // ...
}
```

### PHPDoc Comments

**Add PHPDoc for:**
- Complex array structures
- Generic types
- When return type needs clarification

```php
/**
 * Get products with filtering
 *
 * @param array{
 *     status?: string,
 *     limit?: int,
 *     offset?: int
 * } $filters Optional filters
 * @return list<Product> List of products
 */
public function getProducts(array $filters = []): array
```

### Naming Conventions

```php
// Classes: PascalCase
class CreateBuyUrlRequest {}

// Methods/Variables: camelCase
public function createBuyUrl() {}
private string $apiKey;

// Constants: SCREAMING_SNAKE_CASE
private const int DEFAULT_TIMEOUT = 30;

// Enums: PascalCase with values
enum HttpStatusCode: int {
    case OK = 200;
}
```

## 🐛 Debugging Tips

### XDebug Configuration

Add to `php.ini`:

```ini
[XDebug]
xdebug.mode=debug,develop
xdebug.start_with_request=yes
xdebug.client_port=9003
```

### Common Issues

**"Class not found"**
```bash
composer dump-autoload
```

**"Tests not running"**
```bash
# Verify PHP version
php -v  # Should be 8.4+

# Clear test cache
rm -rf .phpunit.cache
```

**"Code style errors"**
```bash
# Auto-fix most issues
composer cs:fix

# Check what will be fixed
composer cs:check
```

## 📚 Additional Resources

- [README.md](../README.md) - Main documentation
- [PHP 8.4 Features](https://www.php.net/releases/8.4/en.php)
- [PSR-12 Coding Style](https://www.php-fig.org/psr/psr-12/)

## 🤝 Getting Help

- **Issues**: Check existing issues or create a new one
- **Discussions**: Use GitHub Discussions for questions
- **Documentation**: All endpoints documented in `/docs` folder

---

**Happy Coding! 🚀**
