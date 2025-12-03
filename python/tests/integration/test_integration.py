"""Integration tests with real API calls."""

import pytest
from cloze_sdk import ClozeClient
from cloze_sdk.exceptions import ClozeAPIError, ClozeAuthenticationError


@pytest.mark.integration
class TestIntegrationAccount:
    """Integration tests for Account endpoints."""
    
    def test_get_profile(self, real_client):
        """Test getting user profile with real API."""
        profile = real_client.account.get_profile()
        assert "errorcode" in profile
        assert profile["errorcode"] == 0
        assert "user" in profile
    
    def test_get_fields(self, real_client):
        """Test getting custom fields with real API."""
        fields = real_client.account.get_fields()
        assert "errorcode" in fields
        assert fields["errorcode"] == 0
    
    def test_get_fields_with_relationtype(self, real_client):
        """Test getting custom fields filtered by relation type."""
        fields = real_client.account.get_fields(relationtype="person")
        assert "errorcode" in fields
        assert fields["errorcode"] == 0
    
    def test_get_segments_people(self, real_client):
        """Test getting people segments."""
        segments = real_client.account.get_segments_people()
        assert "errorcode" in segments
        assert segments["errorcode"] == 0
    
    def test_get_segments_projects(self, real_client):
        """Test getting project segments."""
        segments = real_client.account.get_segments_projects()
        assert "errorcode" in segments
        assert segments["errorcode"] == 0
    
    def test_get_stages_people(self, real_client):
        """Test getting people stages."""
        stages = real_client.account.get_stages_people()
        assert "errorcode" in stages
        assert stages["errorcode"] == 0
    
    def test_get_stages_projects(self, real_client):
        """Test getting project stages."""
        stages = real_client.account.get_stages_projects()
        assert "errorcode" in stages
        assert stages["errorcode"] == 0
    
    def test_get_steps(self, real_client):
        """Test getting steps."""
        steps = real_client.account.get_steps()
        assert "errorcode" in steps
        assert steps["errorcode"] == 0
    
    def test_get_views(self, real_client):
        """Test getting views."""
        views = real_client.account.get_views()
        assert "errorcode" in views
        assert views["errorcode"] == 0


@pytest.mark.integration
class TestIntegrationTeam:
    """Integration tests for Team endpoints."""
    
    def test_get_roles(self, real_client):
        """Test getting team roles."""
        roles = real_client.team.get_roles()
        assert "errorcode" in roles
        assert roles["errorcode"] == 0
    
    def test_list_members(self, real_client):
        """Test listing team members."""
        members = real_client.team.list_members()
        assert "errorcode" in members
        assert members["errorcode"] == 0
    
    def test_get_nodes(self, real_client):
        """Test getting team nodes."""
        nodes = real_client.team.get_nodes()
        assert "errorcode" in nodes
        assert nodes["errorcode"] == 0


@pytest.mark.integration
class TestIntegrationAnalytics:
    """Integration tests for Analytics endpoints."""
    
    def test_get_team_activity_update(self, real_client):
        """Test getting team activity update status."""
        update = real_client.analytics.get_team_activity_update()
        assert "errorcode" in update
        assert update["errorcode"] == 0


@pytest.mark.integration
class TestIntegrationWebhooks:
    """Integration tests for Webhooks endpoints."""
    
    def test_list_webhooks(self, real_client):
        """Test listing webhooks."""
        webhooks = real_client.webhooks.list()
        assert "errorcode" in webhooks
        assert webhooks["errorcode"] == 0
        assert "list" in webhooks


@pytest.mark.integration
class TestIntegrationErrorHandling:
    """Integration tests for error handling."""
    
    def test_invalid_api_key_raises_error(self):
        """Test that invalid API key raises authentication error."""
        client = ClozeClient(api_key="invalid_key")
        with pytest.raises(ClozeAuthenticationError):
            client.account.get_profile()
    
    def test_invalid_endpoint_handling(self, real_client):
        """Test handling of invalid requests."""
        # This should handle errors gracefully
        try:
            # Try to get a person that doesn't exist - should return errorcode != 0
            result = real_client.people.get("nonexistent@example.com")
            # If it doesn't raise, check errorcode
            if result.get("errorcode") != 0:
                assert "message" in result
        except ClozeAPIError:
            # This is also acceptable - API error was raised
            pass

