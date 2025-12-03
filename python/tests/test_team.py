"""Unit tests for Team endpoints."""

import pytest
from unittest.mock import Mock, patch


class TestTeam:
    """Test Team endpoint methods."""
    
    @pytest.fixture
    def team(self, mock_client):
        """Create Team instance."""
        return mock_client.team
    
    def test_list_members(self, team):
        """Test list_members method."""
        with patch.object(team.client, '_make_request') as mock_request:
            mock_request.return_value = {"errorcode": 0, "list": []}
            
            result = team.list_members()
            
            mock_request.assert_called_once_with(
                "GET",
                "/v1/team/members/list"
            )
            assert result == {"errorcode": 0, "list": []}
    
    def test_update_members(self, team):
        """Test update_members method."""
        members = [{"id": "1", "role": "admin"}]
        with patch.object(team.client, '_make_request') as mock_request:
            mock_request.return_value = {"errorcode": 0}
            
            result = team.update_members(members)
            
            mock_request.assert_called_once_with(
                "POST",
                "/v1/team/members/update",
                json_data={"members": members}
            )
            assert result == {"errorcode": 0}
    
    def test_get_nodes(self, team):
        """Test get_nodes method."""
        with patch.object(team.client, '_make_request') as mock_request:
            mock_request.return_value = {"errorcode": 0, "nodes": []}
            
            result = team.get_nodes()
            
            mock_request.assert_called_once_with(
                "GET",
                "/v1/team/nodes"
            )
            assert result == {"errorcode": 0, "nodes": []}
    
    def test_get_roles(self, team):
        """Test get_roles method."""
        with patch.object(team.client, '_make_request') as mock_request:
            mock_request.return_value = {"errorcode": 0, "list": []}
            
            result = team.get_roles()
            
            mock_request.assert_called_once_with(
                "GET",
                "/v1/team/roles"
            )
            assert result == {"errorcode": 0, "list": []}

