"""Pytest configuration and fixtures."""

import os
import pytest
from unittest.mock import Mock, MagicMock
from cloze_sdk import ClozeClient
from cloze_sdk.exceptions import ClozeAPIError


@pytest.fixture
def mock_response():
    """Create a mock response object."""
    response = Mock()
    response.status_code = 200
    response.json.return_value = {"errorcode": 0, "data": "test"}
    response.headers = {}
    return response


@pytest.fixture
def mock_client(mock_response):
    """Create a mock ClozeClient."""
    client = ClozeClient(api_key="test_api_key")
    client.session = Mock()
    client.session.request.return_value = mock_response
    client.session.headers = {}
    return client


@pytest.fixture
def api_key():
    """Get API key from environment variable."""
    key = os.getenv("CLOZE_API_KEY")
    if not key:
        pytest.skip("CLOZE_API_KEY environment variable not set")
    return key


@pytest.fixture
def real_client(api_key):
    """Create a real ClozeClient for integration tests."""
    return ClozeClient(api_key=api_key)


@pytest.fixture
def sample_person():
    """Sample person data for testing."""
    return {
        "email": "test@example.com",
        "first": "Test",
        "last": "User"
    }


@pytest.fixture
def sample_company():
    """Sample company data for testing."""
    return {
        "name": "Test Company",
        "domain": "testcompany.com"
    }


@pytest.fixture
def sample_project():
    """Sample project data for testing."""
    return {
        "name": "Test Project",
        "value": 10000
    }


@pytest.fixture
def sample_analytics_query():
    """Sample analytics query for testing."""
    return {
        "test_query": {
            "max": 30,
            "scale": "month",
            "measures": ["sentmails", "meetings"]
        }
    }

