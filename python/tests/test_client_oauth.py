"""Additional tests for OAuth and edge cases in ClozeClient."""

import pytest
from unittest.mock import Mock, patch
from cloze_sdk import ClozeClient
from cloze_sdk.exceptions import ClozeAPIError
import requests


class TestClozeClientOAuth:
    """Test OAuth-specific client behavior."""
    
    def test_oauth_token_in_headers_during_init(self):
        """Test that OAuth token is set in headers during initialization."""
        client = ClozeClient(oauth_token="test_oauth_token")
        assert client.session.headers["Authorization"] == "Bearer test_oauth_token"
        assert client.oauth_token == "test_oauth_token"
        assert client.api_key is None


class TestClozeClientEdgeCases:
    """Test edge cases and additional code paths."""
    
    @pytest.fixture
    def client(self):
        """Create a client for testing."""
        return ClozeClient(api_key="test_key")
    
    def test_make_request_with_data_parameter(self, client, mock_response):
        """Test _make_request with data parameter (not json_data)."""
        client.session.request = Mock(return_value=mock_response)
        
        result = client._make_request("POST", "/v1/test", data={"form": "data"})
        
        call_kwargs = client.session.request.call_args[1]
        assert "data" in call_kwargs
        assert call_kwargs["data"] == {"form": "data"}
        assert "json" not in call_kwargs
    
    def test_make_request_json_takes_precedence_over_data(self, client, mock_response):
        """Test that json_data takes precedence over data."""
        client.session.request = Mock(return_value=mock_response)
        
        client._make_request(
            "POST",
            "/v1/test",
            data={"form": "data"},
            json_data={"json": "data"}
        )
        
        call_kwargs = client.session.request.call_args[1]
        assert "json" in call_kwargs
        assert call_kwargs["json"] == {"json": "data"}
        assert "data" not in call_kwargs
    
    def test_handle_response_with_errorcode_and_message(self, client):
        """Test _handle_response with errorcode and custom message."""
        response = Mock()
        response.status_code = 200
        response.json.return_value = {
            "errorcode": 42,
            "message": "Custom error message"
        }
        
        with pytest.raises(ClozeAPIError) as exc_info:
            client._handle_response(response)
        
        assert "Custom error message" in str(exc_info.value)
        assert exc_info.value.errorcode == 42
    
    def test_handle_response_with_errorcode_no_message(self, client):
        """Test _handle_response with errorcode but no message."""
        response = Mock()
        response.status_code = 200
        response.json.return_value = {"errorcode": 99}
        
        with pytest.raises(ClozeAPIError) as exc_info:
            client._handle_response(response)
        
        assert "Unknown API error" in str(exc_info.value)
        assert exc_info.value.errorcode == 99

