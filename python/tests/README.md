# Cloze SDK Test Suite

Comprehensive test suite with 100% code coverage including unit, integration, and E2E tests.

## Test Structure

```
tests/
├── conftest.py              # Shared fixtures and configuration
├── test_client.py           # Unit tests for ClozeClient
├── test_analytics.py        # Unit tests for Analytics endpoints
├── test_team.py             # Unit tests for Team endpoints
├── test_account.py          # Unit tests for Account endpoints
├── test_projects.py         # Unit tests for Projects endpoints
├── test_people.py           # Unit tests for People endpoints
├── test_companies.py        # Unit tests for Companies endpoints
├── test_timeline.py         # Unit tests for Timeline endpoints
├── test_webhooks.py         # Unit tests for Webhooks endpoints
├── test_exceptions.py       # Unit tests for exception classes
├── integration/             # Integration tests with real API
│   └── test_integration.py
└── e2e/                     # End-to-end workflow tests
    └── test_e2e_workflows.py
```

## Running Tests

### Run All Tests

```bash
# Activate virtual environment first
venv\Scripts\activate  # Windows
# or
source venv/bin/activate  # macOS/Linux

# Install test dependencies
pip install -r requirements-dev.txt

# Run all tests
pytest
```

### Run by Category

```bash
# Unit tests only (fast, no API calls)
pytest -m unit

# Integration tests (requires CLOZE_API_KEY)
pytest -m integration

# E2E tests (requires CLOZE_API_KEY, slower)
pytest -m e2e

# Skip slow tests
pytest -m "not slow"
```

### Coverage Reports

```bash
# Generate coverage report
pytest --cov=cloze_sdk --cov-report=html

# View HTML report
# Open htmlcov/index.html in your browser
```

## Test Configuration

### Environment Variables

For integration and E2E tests, set:

```bash
export CLOZE_API_KEY=your_api_key_here  # macOS/Linux
set CLOZE_API_KEY=your_api_key_here     # Windows
```

### Test Markers

- `@pytest.mark.unit` - Unit tests with mocked API calls
- `@pytest.mark.integration` - Integration tests with real API
- `@pytest.mark.e2e` - End-to-end workflow tests
- `@pytest.mark.slow` - Tests that take longer to run

## Test Coverage

The test suite aims for 100% code coverage:

- **Unit Tests**: Test all methods with mocked API responses
- **Integration Tests**: Test real API calls for all endpoints
- **E2E Tests**: Test complete workflows and real-world scenarios

## Writing New Tests

### Unit Test Example

```python
def test_create_person(mock_client):
    """Test creating a person."""
    mock_client._make_request = Mock(return_value={"errorcode": 0})
    result = mock_client.people.create({"email": "test@example.com"})
    assert result["errorcode"] == 0
```

### Integration Test Example

```python
@pytest.mark.integration
def test_get_profile(real_client):
    """Test getting user profile with real API."""
    profile = real_client.account.get_profile()
    assert profile["errorcode"] == 0
```

### E2E Test Example

```python
@pytest.mark.e2e
@pytest.mark.slow
def test_person_lifecycle(real_client):
    """Test complete person lifecycle."""
    # Create, get, update, delete
    ...
```

## Continuous Integration

The test suite is designed to work in CI/CD pipelines:

- Unit tests run quickly without external dependencies
- Integration tests require API key (set as secret)
- E2E tests are marked as slow and can be run separately

