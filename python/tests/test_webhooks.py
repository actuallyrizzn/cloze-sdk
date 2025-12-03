"""Unit tests for Webhooks endpoints."""

import pytest
from unittest.mock import Mock, patch
from cloze_sdk.exceptions import ClozeValidationError


class TestWebhooks:
    """Test Webhooks endpoint methods."""
    
    @pytest.fixture
    def webhooks(self, mock_client):
        """Create Webhooks instance."""
        return mock_client.webhooks
    
    def test_list(self, webhooks):
        """Test list method."""
        with patch.object(webhooks.client, '_make_request') as mock_request:
            mock_request.return_value = {"errorcode": 0, "list": []}
            
            result = webhooks.list()
            
            mock_request.assert_called_once_with(
                "GET",
                "/v1/webhooks"
            )
            assert result == {"errorcode": 0, "list": []}
    
    def test_subscribe(self, webhooks):
        """Test subscribe method."""
        with patch.object(webhooks.client, '_make_request') as mock_request:
            mock_request.return_value = {"errorcode": 0, "uniqueid": "test_id"}
            
            result = webhooks.subscribe(
                event="person.audit.change",
                target_url="https://example.com/webhook"
            )
            
            call_args = mock_request.call_args
            assert call_args[0][0] == "POST"
            assert call_args[0][1] == "/v1/webhooks/subscribe"
            assert call_args[1]["json_data"]["event"] == "person.audit.change"
            assert call_args[1]["json_data"]["target_url"] == "https://example.com/webhook"
            assert result == {"errorcode": 0, "uniqueid": "test_id"}
    
    def test_subscribe_with_all_params(self, webhooks):
        """Test subscribe method with all parameters."""
        with patch.object(webhooks.client, '_make_request') as mock_request:
            mock_request.return_value = {"errorcode": 0, "uniqueid": "test_id"}
            
            filters = [{"person": {"segment": "test"}}]
            result = webhooks.subscribe(
                event="person.audit.change",
                target_url="https://example.com/webhook",
                scope="local",
                filters=filters,
                client_type="human",
                client_reference="test_ref",
                ttl=3600
            )
            
            call_args = mock_request.call_args
            json_data = call_args[1]["json_data"]
            assert json_data["scope"] == "local"
            assert json_data["filters"] == filters
            assert json_data["client_type"] == "human"
            assert json_data["client_reference"] == "test_ref"
            assert json_data["ttl"] == "3600"
    
    def test_unsubscribe_with_uniqueid(self, webhooks):
        """Test unsubscribe method with uniqueid."""
        with patch.object(webhooks.client, '_make_request') as mock_request:
            mock_request.return_value = {"errorcode": 0}
            
            result = webhooks.unsubscribe(
                event="person.audit.change",
                uniqueid="test_id"
            )
            
            call_args = mock_request.call_args
            assert call_args[0][0] == "POST"
            assert call_args[0][1] == "/v1/webhooks/unsubscribe"
            assert call_args[1]["json_data"]["event"] == "person.audit.change"
            assert call_args[1]["json_data"]["uniqueid"] == "test_id"
            assert result == {"errorcode": 0}
    
    def test_unsubscribe_with_client_reference(self, webhooks):
        """Test unsubscribe method with client_reference."""
        with patch.object(webhooks.client, '_make_request') as mock_request:
            mock_request.return_value = {"errorcode": 0}
            
            result = webhooks.unsubscribe(
                event="person.audit.change",
                client_reference="test_ref"
            )
            
            call_args = mock_request.call_args
            json_data = call_args[1]["json_data"]
            assert json_data["event"] == "person.audit.change"
            assert json_data["client_reference"] == "test_ref"
    
    def test_unsubscribe_without_params_raises_error(self, webhooks):
        """Test that unsubscribe without uniqueid or client_reference raises error."""
        with pytest.raises(ValueError, match="Either uniqueid or client_reference must be provided"):
            webhooks.unsubscribe(event="person.audit.change")

