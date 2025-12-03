# PHP SDK Test Suite

## Overview

The PHP SDK includes a comprehensive test suite with 100% code coverage target, organized into three categories:

1. **Unit Tests** - Fast tests with mocked dependencies
2. **Integration Tests** - Tests that make real API calls
3. **E2E Tests** - End-to-end workflow tests

## Test Structure

```
tests/
├── Unit/                    # Unit tests (mocked)
│   ├── TestCase.php        # Base test case with helpers
│   ├── ClientTest.php      # ClozeClient tests
│   ├── AnalyticsTest.php
│   ├── TeamTest.php
│   ├── AccountTest.php
│   ├── ProjectsTest.php
│   ├── PeopleTest.php
│   ├── CompaniesTest.php
│   ├── TimelineTest.php
│   ├── WebhooksTest.php
│   └── ExceptionsTest.php
├── Integration/            # Integration tests (real API)
│   ├── IntegrationTestCase.php
│   ├── AnalyticsIntegrationTest.php
│   ├── TeamIntegrationTest.php
│   ├── AccountIntegrationTest.php
│   ├── ProjectsIntegrationTest.php
│   ├── PeopleIntegrationTest.php
│   ├── CompaniesIntegrationTest.php
│   ├── TimelineIntegrationTest.php
│   └── WebhooksIntegrationTest.php
└── E2E/                     # End-to-end tests
    ├── E2ETestCase.php
    ├── PeopleE2ETest.php
    ├── ProjectsE2ETest.php
    ├── WebhooksE2ETest.php
    └── AnalyticsE2ETest.php
```

## Setup

### Prerequisites

1. PHP 7.4 or higher
2. Composer
3. PHP zip extension (for Composer package installation)

### Installation

```bash
# Install dependencies
composer install
```

**Note:** If you encounter zip extension errors during `composer install`, you may need to:
- Enable the `zip` extension in your `php.ini` file
- Or use `composer install --prefer-source` (slower but doesn't require zip)

### Environment Variables

For integration and E2E tests, set your API key:

```bash
# Windows PowerShell
$env:CLOZE_API_KEY = "your_api_key_here"

# Linux/Mac
export CLOZE_API_KEY="your_api_key_here"
```

## Running Tests

### Using PHPUnit Directly

```bash
# Run all tests
vendor/bin/phpunit

# Run specific test suite
vendor/bin/phpunit --testsuite Unit
vendor/bin/phpunit --testsuite Integration
vendor/bin/phpunit --testsuite E2E

# Run with coverage
vendor/bin/phpunit --coverage-html coverage/html

# Run specific test file
vendor/bin/phpunit tests/Unit/ClientTest.php
```

### Using Makefile

```bash
# Run all tests
make test

# Run specific test suite
make test-unit
make test-integration
make test-e2e

# Run with coverage
make test-coverage
```

## Test Coverage

The test suite aims for 100% code coverage. Coverage reports are generated in:

- **HTML**: `coverage/html/index.html` - Interactive HTML report
- **XML**: `coverage/clover.xml` - For CI/CD integration
- **Text**: Printed to console

### Coverage Report

```bash
vendor/bin/phpunit --coverage-html coverage/html --coverage-clover coverage/clover.xml
```

## Test Categories

### Unit Tests

Unit tests mock all external dependencies (HTTP client) and test the SDK logic in isolation. These tests:
- Are fast (no network calls)
- Test all code paths
- Verify correct API calls are made
- Test error handling

**Example:**
```php
public function testGetProfile(): void
{
    $client = $this->createMockClient(['makeRequest']);
    $client->expects($this->once())
        ->method('makeRequest')
        ->with('GET', '/v1/user/profile')
        ->willReturn(['errorcode' => 0, 'user' => []]);
    
    $this->getAccount($client)->getProfile();
}
```

### Integration Tests

Integration tests make real API calls to verify the SDK works correctly with the actual Cloze API. These tests:
- Require `CLOZE_API_KEY` environment variable
- Make real HTTP requests
- Verify API responses are handled correctly
- May be skipped if API key is not set

**Example:**
```php
public function testGetProfile(): void
{
    $result = $this->client->account->getProfile();
    $this->assertArrayHasKey('errorcode', $result);
}
```

### E2E Tests

End-to-end tests verify complete workflows, such as:
- Creating, reading, updating, and deleting resources
- Webhook subscription lifecycle
- Analytics query workflows
- Feed pagination

**Example:**
```php
public function testCreatePerson(): void
{
    $person = ['email' => 'test@example.com', 'first' => 'Test'];
    $result = $this->client->people->create($person);
    $this->assertEquals(0, $result['errorcode']);
}
```

## Test Files Summary

### Unit Tests (11 files)
- `ClientTest.php` - 15 tests covering client initialization, request handling, response handling, error cases
- `AnalyticsTest.php` - 6 tests for all analytics endpoints
- `TeamTest.php` - 4 tests for team endpoints
- `AccountTest.php` - 9 tests for account endpoints
- `ProjectsTest.php` - 11 tests for projects CRUD and query operations
- `PeopleTest.php` - 11 tests for people CRUD and query operations
- `CompaniesTest.php` - 11 tests for companies CRUD and query operations
- `TimelineTest.php` - 5 tests for timeline endpoints
- `WebhooksTest.php` - 6 tests for webhook operations
- `ExceptionsTest.php` - 7 tests for exception classes

### Integration Tests (9 files)
- Tests for all endpoint categories making real API calls
- 20+ integration tests total

### E2E Tests (5 files)
- `PeopleE2ETest.php` - Complete CRUD workflow for people
- `ProjectsE2ETest.php` - Complete CRUD workflow for projects
- `WebhooksE2ETest.php` - Webhook subscription lifecycle
- `AnalyticsE2ETest.php` - Analytics query workflows

## Configuration

Test configuration is in `phpunit.xml`:

- **Bootstrap**: `tests/bootstrap.php`
- **Test Suites**: Unit, Integration, E2E
- **Coverage**: Includes `src/`, excludes `tests/` and `vendor/`
- **Output**: HTML, XML, and text coverage reports

## Continuous Integration

For CI/CD pipelines:

```bash
# Install dependencies
composer install --no-interaction --prefer-dist

# Run tests with coverage
vendor/bin/phpunit --coverage-clover coverage/clover.xml

# Upload coverage to service (example)
# codecov -f coverage/clover.xml
```

## Troubleshooting

### Composer Install Fails

If `composer install` fails due to missing zip extension:

1. Enable zip extension in `php.ini`:
   ```ini
   extension=zip
   ```

2. Or use source installation:
   ```bash
   composer install --prefer-source
   ```

### Tests Fail with "CLOZE_API_KEY not set"

Integration and E2E tests require an API key. Set the environment variable:

```bash
export CLOZE_API_KEY="your_key_here"
```

### Coverage Not Generated

Ensure `phpunit/php-code-coverage` is installed:

```bash
composer require --dev phpunit/php-code-coverage
```

## Contributing

When adding new features:

1. Add unit tests for all new code paths
2. Add integration tests for new endpoints
3. Add E2E tests for new workflows
4. Ensure 100% code coverage is maintained
5. Run all tests before committing

## Test Statistics

- **Total Test Files**: 25+
- **Unit Tests**: 80+ tests
- **Integration Tests**: 20+ tests
- **E2E Tests**: 10+ tests
- **Target Coverage**: 100%

