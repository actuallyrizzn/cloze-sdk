# Cloze SDK Architecture

This document describes the architecture and design decisions for the Cloze SDK project.

## Overview

The Cloze SDK is a multi-language SDK project providing 100% coverage of the Cloze API. The project is organized with language-specific implementations sharing a common architecture and design philosophy.

## Project Structure

```
cloze-sdk/
├── docs/              # Comprehensive documentation
├── python/            # Python SDK implementation
├── php/               # PHP SDK implementation
├── LICENSE-CODE       # AGPLv3 license for code
└── LICENSE-DOCS       # CC-BY-SA 4.0 license for documentation
```

## Design Principles

### 1. Consistency Across Languages

Both Python and PHP SDKs follow the same architectural patterns:
- Central client class for authentication and request handling
- Modular endpoint classes (Analytics, Team, Account, etc.)
- Consistent error handling with custom exceptions
- Similar method naming conventions (adapted to language conventions)

### 2. 100% API Coverage

Every Cloze API endpoint is implemented in both SDKs:
- Analytics (6 endpoints)
- Team (4 endpoints)
- Account (8 endpoints)
- Projects (6 endpoints)
- People (6 endpoints)
- Companies (6 endpoints)
- Timeline (4 endpoints)
- Webhooks (3 endpoints)

**Total: 43+ endpoints**

### 3. 100% Test Coverage

Both SDKs maintain 100% code coverage through:
- **Unit Tests**: Mocked API calls, fast execution
- **Integration Tests**: Real API calls, verify SDK works with actual API
- **E2E Tests**: Complete workflows, real-world scenarios

### 4. Type Safety

- **Python**: Full type hints throughout
- **PHP**: Type hints for all parameters and return types

## Architecture Components

### Client Layer

The central client class handles:
- Authentication (API Key, OAuth 2.0)
- HTTP request/response handling
- Error parsing and exception raising
- Configuration (base URL, timeout)

**Python:**
```python
class ClozeClient:
    def __init__(self, api_key=None, oauth_token=None, ...)
    def _make_request(self, method, endpoint, ...)
    def _handle_response(self, response)
```

**PHP:**
```php
class ClozeClient {
    public function __construct(?string $apiKey, ?string $oauthToken, ...)
    public function makeRequest(string $method, string $endpoint, ...)
    private function handleResponse(ResponseInterface $response)
}
```

### Endpoint Modules

Each API category is implemented as a separate module/class:

- **Analytics**: Activity, funnel, leads, projects, team metrics
- **Team**: Members, nodes, roles
- **Account**: Profile, fields, segments, stages, steps, views
- **Projects**: CRUD operations, find, feed
- **People**: CRUD operations, find, feed
- **Companies**: CRUD operations, find, feed
- **Timeline**: Communications, content, todos, message opens
- **Webhooks**: List, subscribe, unsubscribe

### Error Handling

Custom exception hierarchy:

**Python:**
```python
ClozeAPIError (base)
├── ClozeAuthenticationError
├── ClozeRateLimitError
└── ClozeValidationError
```

**PHP:**
```php
ClozeAPIError (base)
├── ClozeAuthenticationError
├── ClozeRateLimitError
└── ClozeValidationError
```

## Authentication

The SDKs support three authentication methods:

1. **API Key** - Simplest, uses Bearer token format
2. **OAuth 2.0** - Required for public integrations
3. **Query Parameter** - Alternative API key format (optional)

## Request/Response Flow

```
User Code
    ↓
Endpoint Method (e.g., client.people.create())
    ↓
Client._make_request() / Client->makeRequest()
    ↓
HTTP Client (requests / Guzzle)
    ↓
Cloze API
    ↓
Client._handle_response() / Client->handleResponse()
    ↓
Parse JSON / Raise Exceptions
    ↓
Return Result to User
```

## Testing Architecture

### Test Organization

```
tests/
├── Unit/              # Fast, mocked tests
├── Integration/       # Real API calls
└── E2E/               # Complete workflows
```

### Test Coverage Strategy

1. **Unit Tests**: Mock all external dependencies
   - Test all code paths
   - Test error conditions
   - Fast execution (no network calls)

2. **Integration Tests**: Real API calls
   - Verify SDK works with actual API
   - Test authentication
   - Verify response parsing

3. **E2E Tests**: Complete workflows
   - CRUD lifecycles
   - Webhook subscriptions
   - Complex scenarios

## Documentation Structure

### Root Level
- **README.md**: Lightweight overview, links to SDKs
- **LICENSE-CODE**: AGPLv3 for all code
- **LICENSE-DOCS**: CC-BY-SA 4.0 for documentation

### Language-Specific
- **README.md**: Quick start, installation, basic usage
- **TESTING.md**: Testing guide for that SDK

### Comprehensive Docs (`docs/`)
- **cloze-api-docs.md**: Complete API reference
- **python-sdk-guide.md**: Comprehensive Python guide
- **php-sdk-guide.md**: Comprehensive PHP guide
- **CONTRIBUTING.md**: Contribution guidelines
- **ARCHITECTURE.md**: This document

## Design Decisions

### Why Separate Endpoint Modules?

- **Modularity**: Each module is independent and testable
- **Maintainability**: Changes to one endpoint don't affect others
- **Clarity**: Clear separation of concerns

### Why 100% Test Coverage?

- **Confidence**: Every line of code is tested
- **Refactoring**: Safe to refactor with full test coverage
- **Documentation**: Tests serve as usage examples

### Why Multiple Test Types?

- **Speed**: Unit tests run fast for quick feedback
- **Reliability**: Integration tests verify real API compatibility
- **Completeness**: E2E tests verify end-to-end workflows

### Why Type Hints?

- **IDE Support**: Better autocomplete and error detection
- **Documentation**: Types serve as inline documentation
- **Maintainability**: Easier to understand and modify code

## Future Considerations

### Potential Additions

- Additional language implementations (Node.js, Go, etc.)
- Async/await support where applicable
- Response caching mechanisms
- Rate limiting helpers
- Webhook signature verification utilities

### Scalability

The architecture supports:
- Adding new endpoints without breaking changes
- Adding new language implementations
- Extending functionality through composition
- Maintaining backward compatibility

## License

- **Code**: AGPLv3 - See [`LICENSE-CODE`](../LICENSE-CODE)
- **Documentation**: CC-BY-SA 4.0 - See [`LICENSE-DOCS`](../LICENSE-DOCS)

