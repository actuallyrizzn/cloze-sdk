"""Unit tests for Timeline endpoints."""

import pytest
from unittest.mock import Mock, patch


class TestTimeline:
    """Test Timeline endpoint methods."""
    
    @pytest.fixture
    def timeline(self, mock_client):
        """Create Timeline instance."""
        return mock_client.timeline
    
    def test_create_communication(self, timeline):
        """Test create_communication method."""
        communication = {"type": "email", "subject": "Test"}
        with patch.object(timeline.client, '_make_request') as mock_request:
            mock_request.return_value = {"errorcode": 0}
            
            result = timeline.create_communication(communication)
            
            mock_request.assert_called_once_with(
                "POST",
                "/v1/timeline/communication/create",
                json_data=communication
            )
            assert result == {"errorcode": 0}
    
    def test_create_content(self, timeline):
        """Test create_content method."""
        content = {"type": "note", "text": "Test note"}
        with patch.object(timeline.client, '_make_request') as mock_request:
            mock_request.return_value = {"errorcode": 0}
            
            result = timeline.create_content(content)
            
            mock_request.assert_called_once_with(
                "POST",
                "/v1/timeline/content/create",
                json_data=content
            )
            assert result == {"errorcode": 0}
    
    def test_create_todo(self, timeline):
        """Test create_todo method."""
        todo = {"text": "Test todo", "due": 1234567890}
        with patch.object(timeline.client, '_make_request') as mock_request:
            mock_request.return_value = {"errorcode": 0}
            
            result = timeline.create_todo(todo)
            
            mock_request.assert_called_once_with(
                "POST",
                "/v1/timeline/todo/create",
                json_data=todo
            )
            assert result == {"errorcode": 0}
    
    def test_get_message_opens(self, timeline):
        """Test get_message_opens method."""
        with patch.object(timeline.client, '_make_request') as mock_request:
            mock_request.return_value = {"errorcode": 0, "list": []}
            
            result = timeline.get_message_opens()
            
            mock_request.assert_called_once_with(
                "GET",
                "/v1/messages/opens",
                params={}
            )
            assert result == {"errorcode": 0, "list": []}
    
    def test_get_message_opens_with_params(self, timeline):
        """Test get_message_opens method with parameters."""
        with patch.object(timeline.client, '_make_request') as mock_request:
            mock_request.return_value = {"errorcode": 0, "list": []}
            
            result = timeline.get_message_opens(from_timestamp=1234567890, user="test@example.com")
            
            call_args = mock_request.call_args
            assert call_args[0][0] == "GET"
            assert call_args[0][1] == "/v1/messages/opens"
            assert call_args[1]["params"]["from"] == 1234567890
            assert call_args[1]["params"]["user"] == "test@example.com"

