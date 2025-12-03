# Testing Guide for Cloze PHP SDK

This guide explains how to run tests for the Cloze PHP SDK.

## Test Structure

The test suite is organized into three categories:

1. **Unit Tests** (`tests/Unit/`) - Fast tests with mocked dependencies
2. **Integration Tests** (`tests/Integration/`) - Tests that make real API calls
3. **E2E Tests** (`tests/E2E/`) - End-to-end workflow tests

## Prerequisites

1. Install dependencies:
```bash
composer install
```

2. For integration and E2E tests, set the `CLOZE_API_KEY` environment variable:
```bash
# Windows PowerShell
$env:CLOZE_API_KEY = "your_api_key_here"

# Linux/Mac
export CLOZE_API_KEY="your_api_key_here"
```

## Running Tests

### Run All Tests

```bash
vendor/bin/phpunit
```

### Run Unit Tests Only

```bash
vendor/bin/phpunit --testsuite Unit
```

### Run Integration Tests Only

```bash
vendor/bin/phpunit --testsuite Integration
```

### Run E2E Tests Only

```bash
vendor/bin/phpunit --testsuite E2E
```

### Run with Coverage

```bash
vendor/bin/phpunit --coverage-html coverage/html
```

This generates an HTML coverage report in `coverage/html/`.

### Run Specific Test File

```bash
vendor/bin/phpunit tests/Unit/ClientTest.php
```

## Test Coverage

The test suite aims for 100% code coverage. Coverage reports are generated in:
- HTML: `coverage/html/index.html`
- XML: `coverage/clover.xml`
- Text: Printed to console

## Test Configuration

Test configuration is in `phpunit.xml`. Key settings:
- Bootstrap file: `tests/bootstrap.php`
- Test suites: Unit, Integration, E2E
- Coverage includes: `src/` directory
- Coverage excludes: `tests/` and `vendor/` directories

## Writing Tests

### Unit Test Example

```php
<?php

namespace Cloze\SDK\Tests\Unit;

use Cloze\SDK\ClozeClient;

class MyTest extends TestCase
{
    public function testSomething(): void
    {
        $client = $this->createMockClient(['makeRequest']);
        $client->expects($this->once())
            ->method('makeRequest')
            ->with('GET', '/v1/endpoint')
            ->willReturn(['errorcode' => 0]);
        
        $result = $client->account->getProfile();
        $this->assertEquals(['errorcode' => 0], $result);
    }
}
```

### Integration Test Example

```php
<?php

namespace Cloze\SDK\Tests\Integration;

class MyIntegrationTest extends IntegrationTestCase
{
    public function testRealApiCall(): void
    {
        $result = $this->client->account->getProfile();
        $this->assertArrayHasKey('errorcode', $result);
    }
}
```

## Continuous Integration

For CI/CD pipelines, you can run tests with coverage:

```bash
vendor/bin/phpunit --coverage-clover coverage/clover.xml
```

The coverage XML can be uploaded to services like Codecov or Coveralls.

