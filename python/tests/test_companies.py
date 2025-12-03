"""Unit tests for Companies endpoints."""

import pytest
from unittest.mock import Mock, patch


class TestCompanies:
    """Test Companies endpoint methods."""
    
    @pytest.fixture
    def companies(self, mock_client):
        """Create Companies instance."""
        return mock_client.companies
    
    def test_create(self, companies, sample_company):
        """Test create method."""
        with patch.object(companies.client, '_make_request') as mock_request:
            mock_request.return_value = {"errorcode": 0}
            
            result = companies.create(sample_company)
            
            mock_request.assert_called_once_with(
                "POST",
                "/v1/companies/create",
                json_data=sample_company
            )
            assert result == {"errorcode": 0}
    
    def test_update(self, companies, sample_company):
        """Test update method."""
        with patch.object(companies.client, '_make_request') as mock_request:
            mock_request.return_value = {"errorcode": 0}
            
            result = companies.update(sample_company)
            
            mock_request.assert_called_once_with(
                "POST",
                "/v1/companies/update",
                json_data=sample_company
            )
            assert result == {"errorcode": 0}
    
    def test_get(self, companies):
        """Test get method."""
        with patch.object(companies.client, '_make_request') as mock_request:
            mock_request.return_value = {"errorcode": 0, "company": {}}
            
            result = companies.get("example.com")
            
            mock_request.assert_called_once_with(
                "GET",
                "/v1/companies/get",
                params={"identifier": "example.com"}
            )
            assert result == {"errorcode": 0, "company": {}}
    
    def test_get_with_identifier_type(self, companies):
        """Test get method with identifier_type."""
        with patch.object(companies.client, '_make_request') as mock_request:
            mock_request.return_value = {"errorcode": 0, "company": {}}
            
            result = companies.get("example.com", identifier_type="domain")
            
            mock_request.assert_called_once_with(
                "GET",
                "/v1/companies/get",
                params={"identifier": "example.com", "identifier_type": "domain"}
            )
            assert result == {"errorcode": 0, "company": {}}
    
    def test_delete(self, companies):
        """Test delete method."""
        with patch.object(companies.client, '_make_request') as mock_request:
            mock_request.return_value = {"errorcode": 0}
            
            result = companies.delete("example.com")
            
            mock_request.assert_called_once_with(
                "DELETE",
                "/v1/companies/delete",
                params={"identifier": "example.com"}
            )
            assert result == {"errorcode": 0}
    
    def test_delete_with_identifier_type(self, companies):
        """Test delete method with identifier_type."""
        with patch.object(companies.client, '_make_request') as mock_request:
            mock_request.return_value = {"errorcode": 0}
            
            result = companies.delete("example.com", identifier_type="domain")
            
            mock_request.assert_called_once_with(
                "DELETE",
                "/v1/companies/delete",
                params={"identifier": "example.com", "identifier_type": "domain"}
            )
            assert result == {"errorcode": 0}
    
    def test_find(self, companies):
        """Test find method."""
        with patch.object(companies.client, '_make_request') as mock_request:
            mock_request.return_value = {"errorcode": 0, "list": []}
            
            result = companies.find()
            
            mock_request.assert_called_once_with(
                "GET",
                "/v1/companies/find",
                params={}
            )
            assert result == {"errorcode": 0, "list": []}
    
    def test_feed(self, companies):
        """Test feed method."""
        with patch.object(companies.client, '_make_request') as mock_request:
            mock_request.return_value = {"errorcode": 0, "list": []}
            
            result = companies.feed()
            
            mock_request.assert_called_once_with(
                "GET",
                "/v1/companies/feed",
                params={}
            )
            assert result == {"errorcode": 0, "list": []}

