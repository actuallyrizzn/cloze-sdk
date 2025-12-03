"""Unit tests for ClozeClient."""

import pytest
from unittest.mock import Mock, patch, MagicMock
from cloze_sdk import ClozeClient
from cloze_sdk.exceptions import ClozeAPIError, ClozeAuthenticationError, ClozeRateLimitError
import requests


class TestClozeClient:
    """Test ClozeClient initialization and configuration."""
    
    def test_init_with_api_key(self):
        """Test client initialization with API key."""
        client = ClozeClient(api_key="test_key")
        assert client.api_key == "test_key"
        assert client.oauth_token is None
        assert client.base_url == "https://api.cloze.com"
        assert client.timeout == 30
    
    def test_init_with_oauth_token(self):
        """Test client initialization with OAuth token."""
        client = ClozeClient(oauth_token="test_token")
        assert client.oauth_token == "test_token"
        assert client.api_key is None
    
    def test_init_with_custom_base_url(self):
        """Test client initialization with custom base URL."""
        client = ClozeClient(api_key="test_key", base_url="https://custom.api.com")
        assert client.base_url == "https://custom.api.com"
    
    def test_init_with_custom_timeout(self):
        """Test client initialization with custom timeout."""
        client = ClozeClient(api_key="test_key", timeout=60)
        assert client.timeout == 60
    
    def test_init_without_auth_raises_error(self):
        """Test that initialization without auth raises ValueError."""
        with pytest.raises(ValueError, match="Either api_key or oauth_token must be provided"):
            ClozeClient()
    
    def test_session_headers_set(self):
        """Test that session headers are properly set."""
        client = ClozeClient(api_key="test_key")
        assert "Accept" in client.session.headers
        assert "Content-Type" in client.session.headers
        assert "Authorization" in client.session.headers
        assert client.session.headers["Authorization"] == "Bearer test_key"
    
    def test_oauth_token_in_headers(self):
        """Test that OAuth token is set in headers."""
        client = ClozeClient(oauth_token="test_token")
        assert client.session.headers["Authorization"] == "Bearer test_token"
    
    def test_endpoint_modules_initialized(self):
        """Test that all endpoint modules are initialized."""
        client = ClozeClient(api_key="test_key")
        assert hasattr(client, "analytics")
        assert hasattr(client, "team")
        assert hasattr(client, "account")
        assert hasattr(client, "projects")
        assert hasattr(client, "people")
        assert hasattr(client, "companies")
        assert hasattr(client, "timeline")
        assert hasattr(client, "webhooks")


class TestClozeClientRequestHandling:
    """Test request handling in ClozeClient."""
    
    @pytest.fixture
    def client(self):
        """Create a client for testing."""
        return ClozeClient(api_key="test_key")
    
    def test_make_request_success(self, client, mock_response):
        """Test successful request handling."""
        client.session.request = Mock(return_value=mock_response)
        
        result = client._make_request("GET", "/v1/user/profile")
        assert result == {"errorcode": 0, "data": "test"}
        client.session.request.assert_called_once()
    
    def test_make_request_with_params(self, client, mock_response):
        """Test request with query parameters."""
        client.session.request = Mock(return_value=mock_response)
        
        client._make_request("GET", "/v1/user/profile", params={"key": "value"})
        call_kwargs = client.session.request.call_args[1]
        assert call_kwargs["params"] == {"key": "value"}
    
    def test_make_request_with_json_data(self, client, mock_response):
        """Test request with JSON data."""
        client.session.request = Mock(return_value=mock_response)
        
        client._make_request("POST", "/v1/people/create", json_data={"name": "Test"})
        call_kwargs = client.session.request.call_args[1]
        assert call_kwargs["json"] == {"name": "Test"}
    
    def test_make_request_with_api_key_param(self, client, mock_response):
        """Test request with API key as query parameter."""
        client.session.request = Mock(return_value=mock_response)
        
        client._make_request("GET", "/v1/user/profile", use_api_key_param=True)
        call_kwargs = client.session.request.call_args[1]
        assert call_kwargs["params"]["api_key"] == "test_key"
    
    def test_make_request_handles_request_exception(self, client):
        """Test that request exceptions are handled."""
        client.session.request = Mock(side_effect=requests.exceptions.RequestException("Connection error"))
        
        with pytest.raises(ClozeAPIError, match="Request failed"):
            client._make_request("GET", "/v1/user/profile")
    
    def test_handle_response_success(self, client):
        """Test successful response handling."""
        response = Mock()
        response.status_code = 200
        response.json.return_value = {"errorcode": 0, "data": "success"}
        
        result = client._handle_response(response)
        assert result == {"errorcode": 0, "data": "success"}
    
    def test_handle_response_with_errorcode(self, client):
        """Test response with non-zero errorcode."""
        response = Mock()
        response.status_code = 200
        response.json.return_value = {"errorcode": 1, "message": "Error occurred"}
        
        with pytest.raises(ClozeAPIError, match="API error: Error occurred"):
            client._handle_response(response)
    
    def test_handle_response_rate_limit(self, client):
        """Test rate limit response handling."""
        response = Mock()
        response.status_code = 429
        
        with pytest.raises(ClozeRateLimitError):
            client._handle_response(response)
    
    def test_handle_response_authentication_error(self, client):
        """Test authentication error response handling."""
        response = Mock()
        response.status_code = 401
        
        with pytest.raises(ClozeAuthenticationError):
            client._handle_response(response)
    
    def test_handle_response_invalid_json(self, client):
        """Test handling of invalid JSON response."""
        response = Mock()
        response.status_code = 200
        response.json.side_effect = ValueError("Invalid JSON")
        
        with pytest.raises(ClozeAPIError, match="Invalid response format"):
            client._handle_response(response)
    
    def test_handle_response_non_json_response(self, client):
        """Test handling of non-JSON response."""
        response = Mock()
        response.status_code = 500
        response.json.side_effect = ValueError("Invalid JSON")
        
        with pytest.raises(ClozeAPIError):
            client._handle_response(response)
    
    def test_make_request_with_data_not_json(self, client, mock_response):
        """Test request with data parameter instead of json_data."""
        client.session.request = Mock(return_value=mock_response)
        
        client._make_request("POST", "/v1/test", data={"key": "value"})
        call_kwargs = client.session.request.call_args[1]
        assert "data" in call_kwargs
        assert "json" not in call_kwargs
    
    def test_make_request_with_both_data_and_json(self, client, mock_response):
        """Test that json_data takes precedence over data."""
        client.session.request = Mock(return_value=mock_response)
        
        client._make_request("POST", "/v1/test", data={"key": "value"}, json_data={"json": "data"})
        call_kwargs = client.session.request.call_args[1]
        assert "json" in call_kwargs
        assert "data" not in call_kwargs

