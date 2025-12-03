# Testing Guide for Cloze Python SDK

This document describes the comprehensive test suite for the Cloze Python SDK, which achieves **100% code coverage**.

## Test Structure

The test suite is organized into three categories:

### 1. Unit Tests (`tests/test_*.py`)

Unit tests use mocked API calls and test all SDK methods in isolation. These tests:
- Run quickly (no network calls)
- Test all code paths
- Achieve 100% code coverage
- Can run without API credentials

**Test Files:**
- `test_client.py` - ClozeClient initialization and request handling
- `test_client_oauth.py` - OAuth-specific behavior and edge cases
- `test_analytics.py` - Analytics endpoints
- `test_team.py` - Team endpoints
- `test_account.py` - Account endpoints
- `test_projects.py` - Projects endpoints
- `test_people.py` - People endpoints
- `test_companies.py` - Companies endpoints
- `test_timeline.py` - Timeline endpoints
- `test_webhooks.py` - Webhooks endpoints
- `test_exceptions.py` - Exception classes
- `test_all_endpoints.py` - Comprehensive endpoint coverage tests

### 2. Integration Tests (`tests/integration/`)

Integration tests make real API calls to verify the SDK works correctly with the Cloze API. These tests:
- Require `CLOZE_API_KEY` environment variable
- Test actual API responses
- Verify authentication and error handling
- Are marked with `@pytest.mark.integration`

**Test File:**
- `test_integration.py` - Real API calls for all endpoint categories

### 3. E2E Tests (`tests/e2e/`)

End-to-end tests verify complete workflows and real-world usage scenarios. These tests:
- Require `CLOZE_API_KEY` environment variable
- Test full CRUD lifecycles
- Test complex workflows
- Are marked with `@pytest.mark.e2e` and `@pytest.mark.slow`

**Test File:**
- `test_e2e_workflows.py` - Complete workflow tests

## Running Tests

### Prerequisites

```bash
# Activate virtual environment
venv\Scripts\activate  # Windows
# or
source venv/bin/activate  # macOS/Linux

# Install dependencies
pip install -r requirements-dev.txt
```

### Run Unit Tests (100% Coverage)

```bash
# Run all unit tests with coverage
pytest -m "not integration and not e2e" -v --cov=cloze_sdk --cov-report=term-missing --cov-fail-under=100

# Or use the Makefile
make test

# Or use the test runner
python run_tests.py unit
```

### Run Integration Tests

```bash
# Set API key
export CLOZE_API_KEY=your_api_key  # macOS/Linux
set CLOZE_API_KEY=your_api_key     # Windows

# Run integration tests
pytest -m integration -v

# Or use the test runner
python run_tests.py integration
```

### Run E2E Tests

```bash
# Set API key
export CLOZE_API_KEY=your_api_key

# Run E2E tests
pytest -m e2e -v -s

# Or use the test runner
python run_tests.py e2e
```

### Run All Tests

```bash
pytest -v --cov=cloze_sdk --cov-report=term-missing

# Or use the test runner
python run_tests.py all
```

## Coverage Reports

### Generate HTML Coverage Report

```bash
pytest -m "not integration and not e2e" --cov=cloze_sdk --cov-report=html
# Open htmlcov/index.html in your browser
```

### View Coverage in Terminal

```bash
pytest -m "not integration and not e2e" --cov=cloze_sdk --cov-report=term-missing
```

## Test Coverage

The test suite achieves **100% code coverage** for all SDK modules:

- ✅ `cloze_sdk/__init__.py` - 100%
- ✅ `cloze_sdk/client.py` - 100%
- ✅ `cloze_sdk/exceptions.py` - 100%
- ✅ `cloze_sdk/analytics.py` - 100%
- ✅ `cloze_sdk/team.py` - 100%
- ✅ `cloze_sdk/account.py` - 100%
- ✅ `cloze_sdk/projects.py` - 100%
- ✅ `cloze_sdk/people.py` - 100%
- ✅ `cloze_sdk/companies.py` - 100%
- ✅ `cloze_sdk/timeline.py` - 100%
- ✅ `cloze_sdk/webhooks.py` - 100%

**Total Coverage: 100%**

## Test Markers

Tests are organized using pytest markers:

- `@pytest.mark.unit` - Unit tests (default, no marker needed)
- `@pytest.mark.integration` - Integration tests
- `@pytest.mark.e2e` - End-to-end tests
- `@pytest.mark.slow` - Tests that take longer to run

## Continuous Integration

The test suite is designed for CI/CD:

```yaml
# Example GitHub Actions workflow
- name: Run unit tests
  run: |
    pip install -r requirements-dev.txt
    pytest -m "not integration and not e2e" --cov=cloze_sdk --cov-fail-under=100

- name: Run integration tests
  env:
    CLOZE_API_KEY: ${{ secrets.CLOZE_API_KEY }}
  run: pytest -m integration -v
```

## Writing New Tests

### Unit Test Example

```python
def test_create_person(people, sample_person):
    """Test creating a person."""
    with patch.object(people.client, '_make_request') as mock_request:
        mock_request.return_value = {"errorcode": 0}
        
        result = people.create(sample_person)
        
        mock_request.assert_called_once_with(
            "POST",
            "/v1/people/create",
            json_data=sample_person
        )
        assert result["errorcode"] == 0
```

### Integration Test Example

```python
@pytest.mark.integration
def test_get_profile(real_client):
    """Test getting user profile with real API."""
    profile = real_client.account.get_profile()
    assert profile["errorcode"] == 0
    assert "user" in profile
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

## Troubleshooting

### Tests Fail with Import Errors

```bash
# Make sure you're in the virtual environment
venv\Scripts\activate  # Windows
source venv/bin/activate  # macOS/Linux

# Install dependencies
pip install -r requirements-dev.txt
```

### Integration/E2E Tests Skip

Integration and E2E tests will skip if `CLOZE_API_KEY` is not set. This is expected behavior.

### Coverage Below 100%

If coverage is below 100%, check the coverage report:

```bash
pytest --cov=cloze_sdk --cov-report=term-missing
```

Look for missing lines and add tests to cover them.

## Best Practices

1. **Always run unit tests before committing** - They're fast and ensure 100% coverage
2. **Run integration tests before releases** - Verify real API compatibility
3. **Use E2E tests for validation** - Test complete workflows
4. **Keep tests isolated** - Each test should be independent
5. **Use descriptive test names** - Make it clear what each test validates
6. **Mock external dependencies** - Unit tests should not make network calls

