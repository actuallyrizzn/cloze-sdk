"""Unit tests for People endpoints."""

import pytest
from unittest.mock import Mock, patch


class TestPeople:
    """Test People endpoint methods."""
    
    @pytest.fixture
    def people(self, mock_client):
        """Create People instance."""
        return mock_client.people
    
    def test_create(self, people, sample_person):
        """Test create method."""
        with patch.object(people.client, '_make_request') as mock_request:
            mock_request.return_value = {"errorcode": 0}
            
            result = people.create(sample_person)
            
            mock_request.assert_called_once_with(
                "POST",
                "/v1/people/create",
                json_data=sample_person
            )
            assert result == {"errorcode": 0}
    
    def test_update(self, people, sample_person):
        """Test update method."""
        with patch.object(people.client, '_make_request') as mock_request:
            mock_request.return_value = {"errorcode": 0}
            
            result = people.update(sample_person)
            
            mock_request.assert_called_once_with(
                "POST",
                "/v1/people/update",
                json_data=sample_person
            )
            assert result == {"errorcode": 0}
    
    def test_get(self, people):
        """Test get method."""
        with patch.object(people.client, '_make_request') as mock_request:
            mock_request.return_value = {"errorcode": 0, "person": {}}
            
            result = people.get("test@example.com")
            
            mock_request.assert_called_once_with(
                "GET",
                "/v1/people/get",
                params={"identifier": "test@example.com"}
            )
            assert result == {"errorcode": 0, "person": {}}
    
    def test_get_with_identifier_type(self, people):
        """Test get method with identifier_type."""
        with patch.object(people.client, '_make_request') as mock_request:
            mock_request.return_value = {"errorcode": 0, "person": {}}
            
            result = people.get("test@example.com", identifier_type="email")
            
            mock_request.assert_called_once_with(
                "GET",
                "/v1/people/get",
                params={"identifier": "test@example.com", "identifier_type": "email"}
            )
            assert result == {"errorcode": 0, "person": {}}
    
    def test_delete_with_identifier_type(self, people):
        """Test delete method with identifier_type."""
        with patch.object(people.client, '_make_request') as mock_request:
            mock_request.return_value = {"errorcode": 0}
            
            result = people.delete("test@example.com", identifier_type="email")
            
            mock_request.assert_called_once_with(
                "DELETE",
                "/v1/people/delete",
                params={"identifier": "test@example.com", "identifier_type": "email"}
            )
            assert result == {"errorcode": 0}
    
    def test_delete(self, people):
        """Test delete method."""
        with patch.object(people.client, '_make_request') as mock_request:
            mock_request.return_value = {"errorcode": 0}
            
            result = people.delete("test@example.com")
            
            mock_request.assert_called_once_with(
                "DELETE",
                "/v1/people/delete",
                params={"identifier": "test@example.com"}
            )
            assert result == {"errorcode": 0}
    
    def test_find(self, people):
        """Test find method."""
        with patch.object(people.client, '_make_request') as mock_request:
            mock_request.return_value = {"errorcode": 0, "list": []}
            
            result = people.find()
            
            mock_request.assert_called_once_with(
                "GET",
                "/v1/people/find",
                params={}
            )
            assert result == {"errorcode": 0, "list": []}
    
    def test_feed(self, people):
        """Test feed method."""
        with patch.object(people.client, '_make_request') as mock_request:
            mock_request.return_value = {"errorcode": 0, "list": []}
            
            result = people.feed()
            
            mock_request.assert_called_once_with(
                "GET",
                "/v1/people/feed",
                params={}
            )
            assert result == {"errorcode": 0, "list": []}

