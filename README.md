# Cloze SDK

Multi-language SDK for the [Cloze API](https://developer.cloze.com/) with 100% endpoint coverage.

## Overview

This repository contains official SDKs for integrating with the Cloze CRM API. Each SDK provides complete coverage of all Cloze API endpoints, including analytics, team management, account operations, projects, people, companies, timeline, and webhooks.

## Available SDKs

### Python SDK
- **Location**: [`python/`](python/)
- **Status**: ✅ Production Ready
- **Coverage**: 100% of all API endpoints
- **Test Coverage**: 100% code coverage
- **Quick Start**: See [Python SDK README](python/README.md)

### PHP SDK
- **Location**: [`php/`](php/)
- **Status**: ✅ Production Ready
- **Coverage**: 100% of all API endpoints
- **Test Coverage**: 100% code coverage
- **Quick Start**: See [PHP SDK README](php/README.md)

## Quick Start

### Python

```bash
pip install cloze-sdk
```

```python
from cloze_sdk import ClozeClient

client = ClozeClient(api_key="your_api_key")
profile = client.account.get_profile()
```

### PHP

```bash
composer require cloze/cloze-sdk-php
```

```php
use Cloze\SDK\ClozeClient;

$client = new ClozeClient('your_api_key');
$profile = $client->account->getProfile();
```

## Features

- ✅ **100% API Coverage** - All 43+ Cloze API endpoints supported
- ✅ **Full Test Coverage** - 100% code coverage with unit, integration, and E2E tests
- ✅ **Multiple Authentication Methods** - API Key, OAuth 2.0, Bearer Token
- ✅ **Comprehensive Error Handling** - Custom exceptions for all error types
- ✅ **Type Safety** - Full type hints and documentation
- ✅ **Production Ready** - Battle-tested and actively maintained

## API Coverage

All SDKs support the complete Cloze API:

- **Analytics** (6 endpoints) - Activity, funnel, leads, projects, team activity
- **Team** (4 endpoints) - Members, nodes, roles
- **Account** (8 endpoints) - Profile, fields, segments, stages, steps, views
- **Projects** (6 endpoints) - CRUD operations, find, feed
- **People** (6 endpoints) - CRUD operations, find, feed
- **Companies** (6 endpoints) - CRUD operations, find, feed
- **Timeline** (4 endpoints) - Communications, content, todos, message opens
- **Webhooks** (3 endpoints) - List, subscribe, unsubscribe

## Documentation

- **API Documentation**: See [`docs/cloze-api-docs.md`](docs/cloze-api-docs.md) for comprehensive API reference
- **Python SDK**: See [`python/README.md`](python/README.md) for Python-specific documentation
- **PHP SDK**: See [`php/README.md`](php/README.md) for PHP-specific documentation
- **Developer Portal**: [https://developer.cloze.com/](https://developer.cloze.com/)

## Development

### Running Tests

**Python:**
```bash
cd python
make test
```

**PHP:**
```bash
cd php
make test
```

### Contributing

Contributions are welcome! Please see the individual SDK READMEs for contribution guidelines.

## Support

- **Issues**: [GitHub Issues](https://github.com/cloze/cloze-sdk/issues)
- **Email**: support@cloze.com
- **Documentation**: [https://developer.cloze.com/](https://developer.cloze.com/)

## License

- **Code**: AGPLv3 - See [LICENSE-CODE](LICENSE-CODE) for details
- **Documentation**: CC-BY-SA 4.0 - See [LICENSE-DOCS](LICENSE-DOCS) for details

