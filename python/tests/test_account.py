"""Unit tests for Account endpoints."""

import pytest
from unittest.mock import Mock, patch


class TestAccount:
    """Test Account endpoint methods."""
    
    @pytest.fixture
    def account(self, mock_client):
        """Create Account instance."""
        return mock_client.account
    
    def test_get_fields(self, account):
        """Test get_fields method without relationtype."""
        with patch.object(account.client, '_make_request') as mock_request:
            mock_request.return_value = {"errorcode": 0, "list": []}
            
            result = account.get_fields()
            
            mock_request.assert_called_once_with(
                "GET",
                "/v1/user/fields",
                params={}
            )
            assert result == {"errorcode": 0, "list": []}
    
    def test_get_fields_with_relationtype(self, account):
        """Test get_fields method with relationtype."""
        with patch.object(account.client, '_make_request') as mock_request:
            mock_request.return_value = {"errorcode": 0, "list": []}
            
            result = account.get_fields(relationtype="person")
            
            mock_request.assert_called_once_with(
                "GET",
                "/v1/user/fields",
                params={"relationtype": "person"}
            )
            assert result == {"errorcode": 0, "list": []}
    
    def test_get_profile(self, account):
        """Test get_profile method."""
        with patch.object(account.client, '_make_request') as mock_request:
            mock_request.return_value = {"errorcode": 0, "user": {}}
            
            result = account.get_profile()
            
            mock_request.assert_called_once_with(
                "GET",
                "/v1/user/profile"
            )
            assert result == {"errorcode": 0, "user": {}}
    
    def test_get_segments_people(self, account):
        """Test get_segments_people method."""
        with patch.object(account.client, '_make_request') as mock_request:
            mock_request.return_value = {"errorcode": 0, "list": []}
            
            result = account.get_segments_people()
            
            mock_request.assert_called_once_with(
                "GET",
                "/v1/user/segments/people"
            )
            assert result == {"errorcode": 0, "list": []}
    
    def test_get_segments_projects(self, account):
        """Test get_segments_projects method."""
        with patch.object(account.client, '_make_request') as mock_request:
            mock_request.return_value = {"errorcode": 0, "list": []}
            
            result = account.get_segments_projects()
            
            mock_request.assert_called_once_with(
                "GET",
                "/v1/user/segments/projects"
            )
            assert result == {"errorcode": 0, "list": []}
    
    def test_get_stages_people(self, account):
        """Test get_stages_people method."""
        with patch.object(account.client, '_make_request') as mock_request:
            mock_request.return_value = {"errorcode": 0, "list": []}
            
            result = account.get_stages_people()
            
            mock_request.assert_called_once_with(
                "GET",
                "/v1/user/stages/people"
            )
            assert result == {"errorcode": 0, "list": []}
    
    def test_get_stages_projects(self, account):
        """Test get_stages_projects method."""
        with patch.object(account.client, '_make_request') as mock_request:
            mock_request.return_value = {"errorcode": 0, "list": []}
            
            result = account.get_stages_projects()
            
            mock_request.assert_called_once_with(
                "GET",
                "/v1/user/stages/projects"
            )
            assert result == {"errorcode": 0, "list": []}
    
    def test_get_steps(self, account):
        """Test get_steps method."""
        with patch.object(account.client, '_make_request') as mock_request:
            mock_request.return_value = {"errorcode": 0, "list": []}
            
            result = account.get_steps()
            
            mock_request.assert_called_once_with(
                "GET",
                "/v1/user/steps"
            )
            assert result == {"errorcode": 0, "list": []}
    
    def test_get_views(self, account):
        """Test get_views method."""
        with patch.object(account.client, '_make_request') as mock_request:
            mock_request.return_value = {"errorcode": 0, "list": []}
            
            result = account.get_views()
            
            mock_request.assert_called_once_with(
                "GET",
                "/v1/user/views"
            )
            assert result == {"errorcode": 0, "list": []}

