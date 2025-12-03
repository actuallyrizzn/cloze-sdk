# Cloze PHP SDK

PHP SDK for the Cloze API with 100% endpoint coverage and 100% test coverage.

## Installation

```bash
composer require cloze/cloze-sdk-php
```

Or from source:

```bash
git clone https://github.com/cloze/cloze-sdk
cd cloze-sdk/php
composer install
```

## Quick Start

```php
<?php

require 'vendor/autoload.php';

use Cloze\SDK\ClozeClient;

// Initialize with API key
$client = new ClozeClient('your_api_key');

// Or with OAuth token
$client = new ClozeClient(null, 'your_oauth_token');

// Get user profile
$profile = $client->account->getProfile();

// Create a person
$person = $client->people->create([
    'email' => 'john@example.com',
    'first' => 'John',
    'last' => 'Doe'
]);

// Query analytics
$activity = $client->analytics->queryActivity([
    'my_query' => [
        'period_scale' => 'month',
        'periods' => 1,
        'measures' => ['sentmails', 'meetings']
    ]
]);
```

## Features

- ✅ 100% API endpoint coverage (43+ endpoints)
- ✅ 100% code coverage with comprehensive tests
- ✅ PSR-4 autoloading
- ✅ Multiple authentication methods (API Key, OAuth 2.0)
- ✅ Custom exception classes for error handling
- ✅ Full support for all Cloze API features

## Requirements

- PHP 7.4+
- Guzzle HTTP Client 7.0+

## Development

### Setup

```bash
# Install dependencies
composer install
```

### Running Tests

```bash
# Unit tests
make test-unit

# Integration tests (requires CLOZE_API_KEY)
make test-integration

# E2E tests (requires CLOZE_API_KEY)
make test-e2e

# All tests
make test-all

# With coverage
make test-coverage
```

See [`TESTING.md`](TESTING.md) for detailed testing documentation.

## API Reference

All Cloze API endpoints are available through the client:

- `$client->analytics->*` - Analytics endpoints
- `$client->team->*` - Team management
- `$client->account->*` - Account operations
- `$client->projects->*` - Project CRUD
- `$client->people->*` - People CRUD
- `$client->companies->*` - Company CRUD
- `$client->timeline->*` - Timeline operations
- `$client->webhooks->*` - Webhook management

See [`../docs/cloze-api-docs.md`](../docs/cloze-api-docs.md) for complete API documentation.

## Error Handling

```php
use Cloze\SDK\Exceptions\ClozeAPIError;
use Cloze\SDK\Exceptions\ClozeAuthenticationError;
use Cloze\SDK\Exceptions\ClozeRateLimitError;

try {
    $result = $client->account->getProfile();
} catch (ClozeAuthenticationError $e) {
    echo "Authentication failed\n";
} catch (ClozeRateLimitError $e) {
    echo "Rate limit exceeded\n";
} catch (ClozeAPIError $e) {
    echo "API error: " . $e->getMessage() . "\n";
}
```

## Documentation

- **Full API Docs**: [`../docs/cloze-api-docs.md`](../docs/cloze-api-docs.md)
- **Testing Guide**: [`TESTING.md`](TESTING.md)
- **Developer Portal**: [https://developer.cloze.com/](https://developer.cloze.com/)

## License

AGPLv3 - See [`../LICENSE-CODE`](../LICENSE-CODE) for details.

## Support

- **Issues**: [GitHub Issues](https://github.com/cloze/cloze-sdk/issues)
- **Email**: support@cloze.com
