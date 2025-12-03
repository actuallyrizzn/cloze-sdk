"""Unit tests for Projects endpoints."""

import pytest
from unittest.mock import Mock, patch


class TestProjects:
    """Test Projects endpoint methods."""
    
    @pytest.fixture
    def projects(self, mock_client):
        """Create Projects instance."""
        return mock_client.projects
    
    def test_create(self, projects, sample_project):
        """Test create method."""
        with patch.object(projects.client, '_make_request') as mock_request:
            mock_request.return_value = {"errorcode": 0}
            
            result = projects.create(sample_project)
            
            mock_request.assert_called_once_with(
                "POST",
                "/v1/projects/create",
                json_data=sample_project
            )
            assert result == {"errorcode": 0}
    
    def test_update(self, projects, sample_project):
        """Test update method."""
        with patch.object(projects.client, '_make_request') as mock_request:
            mock_request.return_value = {"errorcode": 0}
            
            result = projects.update(sample_project)
            
            mock_request.assert_called_once_with(
                "POST",
                "/v1/projects/update",
                json_data=sample_project
            )
            assert result == {"errorcode": 0}
    
    def test_get(self, projects):
        """Test get method."""
        with patch.object(projects.client, '_make_request') as mock_request:
            mock_request.return_value = {"errorcode": 0, "project": {}}
            
            result = projects.get("test@example.com")
            
            mock_request.assert_called_once_with(
                "GET",
                "/v1/projects/get",
                params={"identifier": "test@example.com"}
            )
            assert result == {"errorcode": 0, "project": {}}
    
    def test_get_with_identifier_type(self, projects):
        """Test get method with identifier_type."""
        with patch.object(projects.client, '_make_request') as mock_request:
            mock_request.return_value = {"errorcode": 0, "project": {}}
            
            result = projects.get("test@example.com", identifier_type="email")
            
            mock_request.assert_called_once_with(
                "GET",
                "/v1/projects/get",
                params={"identifier": "test@example.com", "identifier_type": "email"}
            )
            assert result == {"errorcode": 0, "project": {}}
    
    def test_delete(self, projects):
        """Test delete method."""
        with patch.object(projects.client, '_make_request') as mock_request:
            mock_request.return_value = {"errorcode": 0}
            
            result = projects.delete("test@example.com")
            
            mock_request.assert_called_once_with(
                "DELETE",
                "/v1/projects/delete",
                params={"identifier": "test@example.com"}
            )
            assert result == {"errorcode": 0}
    
    def test_find(self, projects):
        """Test find method."""
        with patch.object(projects.client, '_make_request') as mock_request:
            mock_request.return_value = {"errorcode": 0, "list": []}
            
            result = projects.find()
            
            mock_request.assert_called_once_with(
                "GET",
                "/v1/projects/find",
                params={}
            )
            assert result == {"errorcode": 0, "list": []}
    
    def test_find_with_params(self, projects):
        """Test find method with parameters."""
        with patch.object(projects.client, '_make_request') as mock_request:
            mock_request.return_value = {"errorcode": 0, "list": []}
            
            result = projects.find(
                query={"segment": "test"},
                pagenumber=1,
                pagesize=10,
                countonly=False
            )
            
            call_args = mock_request.call_args
            assert call_args[0][0] == "GET"
            assert call_args[0][1] == "/v1/projects/find"
            assert call_args[1]["params"]["segment"] == "test"
            assert call_args[1]["params"]["pagenumber"] == 1
            assert call_args[1]["params"]["pagesize"] == 10
            assert call_args[1]["params"]["countonly"] is False
    
    def test_feed(self, projects):
        """Test feed method."""
        with patch.object(projects.client, '_make_request') as mock_request:
            mock_request.return_value = {"errorcode": 0, "list": [], "cursor": "next"}
            
            result = projects.feed()
            
            mock_request.assert_called_once_with(
                "GET",
                "/v1/projects/feed",
                params={}
            )
            assert result == {"errorcode": 0, "list": [], "cursor": "next"}
    
    def test_feed_with_cursor(self, projects):
        """Test feed method with cursor."""
        with patch.object(projects.client, '_make_request') as mock_request:
            mock_request.return_value = {"errorcode": 0, "list": []}
            
            result = projects.feed(cursor="test_cursor", segment="test", stage="active")
            
            call_args = mock_request.call_args
            assert call_args[0][0] == "GET"
            assert call_args[0][1] == "/v1/projects/feed"
            assert call_args[1]["params"]["cursor"] == "test_cursor"
            assert call_args[1]["params"]["segment"] == "test"
            assert call_args[1]["params"]["stage"] == "active"
    
    def test_delete_with_identifier_type(self, projects):
        """Test delete method with identifier_type."""
        with patch.object(projects.client, '_make_request') as mock_request:
            mock_request.return_value = {"errorcode": 0}
            
            result = projects.delete("test@example.com", identifier_type="email")
            
            mock_request.assert_called_once_with(
                "DELETE",
                "/v1/projects/delete",
                params={"identifier": "test@example.com", "identifier_type": "email"}
            )
            assert result == {"errorcode": 0}

