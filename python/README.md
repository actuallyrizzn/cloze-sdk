# Cloze Python SDK

Python SDK for the Cloze API with 100% endpoint coverage and 100% test coverage.

## Installation

```bash
pip install cloze-sdk
```

Or from source:

```bash
git clone https://github.com/cloze/cloze-sdk
cd cloze-sdk/python
pip install -e .
```

## Quick Start

```python
from cloze_sdk import ClozeClient

# Initialize with API key
client = ClozeClient(api_key="your_api_key")

# Or with OAuth token
client = ClozeClient(oauth_token="your_oauth_token")

# Get user profile
profile = client.account.get_profile()

# Create a person
person = client.people.create({
    "email": "john@example.com",
    "first": "John",
    "last": "Doe"
})

# Query analytics
activity = client.analytics.query_activity({
    "my_query": {
        "period_scale": "month",
        "periods": 1,
        "measures": ["sentmails", "meetings"]
    }
})
```

## Features

- ✅ 100% API endpoint coverage (43+ endpoints)
- ✅ 100% code coverage with comprehensive tests
- ✅ Type hints throughout
- ✅ Multiple authentication methods (API Key, OAuth 2.0)
- ✅ Custom exception classes for error handling
- ✅ Full support for all Cloze API features

## Requirements

- Python 3.7+
- `requests` library

## Development

### Setup

```bash
# Create virtual environment
python -m venv venv

# Activate (Windows)
venv\Scripts\activate

# Activate (macOS/Linux)
source venv/bin/activate

# Install dependencies
pip install -r requirements-dev.txt
```

### Running Tests

```bash
# Unit tests (100% coverage)
make test

# Integration tests (requires CLOZE_API_KEY)
make test-integration

# E2E tests (requires CLOZE_API_KEY)
make test-e2e

# All tests
make test-all
```

See [`TESTING.md`](TESTING.md) for detailed testing documentation.

## API Reference

All Cloze API endpoints are available through the client:

- `client.analytics.*` - Analytics endpoints
- `client.team.*` - Team management
- `client.account.*` - Account operations
- `client.projects.*` - Project CRUD
- `client.people.*` - People CRUD
- `client.companies.*` - Company CRUD
- `client.timeline.*` - Timeline operations
- `client.webhooks.*` - Webhook management

See [`../docs/cloze-api-docs.md`](../docs/cloze-api-docs.md) for complete API documentation.

## Error Handling

```python
from cloze_sdk import (
    ClozeAPIError,
    ClozeAuthenticationError,
    ClozeRateLimitError
)

try:
    result = client.account.get_profile()
except ClozeAuthenticationError:
    print("Authentication failed")
except ClozeRateLimitError:
    print("Rate limit exceeded")
except ClozeAPIError as e:
    print(f"API error: {e}")
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
