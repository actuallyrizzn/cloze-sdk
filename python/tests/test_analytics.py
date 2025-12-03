"""Unit tests for Analytics endpoints."""

import pytest
from unittest.mock import Mock, patch
from cloze_sdk.exceptions import ClozeAPIError


class TestAnalytics:
    """Test Analytics endpoint methods."""
    
    @pytest.fixture
    def analytics(self, mock_client):
        """Create Analytics instance."""
        return mock_client.analytics
    
    def test_query_activity(self, analytics, sample_analytics_query):
        """Test query_activity method."""
        with patch.object(analytics.client, '_make_request') as mock_request:
            mock_request.return_value = {"errorcode": 0, "data": {}}
            
            result = analytics.query_activity(sample_analytics_query)
            
            mock_request.assert_called_once_with(
                "POST",
                "/v1/analytics/activity",
                json_data={"queries": sample_analytics_query}
            )
            assert result == {"errorcode": 0, "data": {}}
    
    def test_query_funnel(self, analytics, sample_analytics_query):
        """Test query_funnel method."""
        with patch.object(analytics.client, '_make_request') as mock_request:
            mock_request.return_value = {"errorcode": 0, "data": {}}
            
            result = analytics.query_funnel(sample_analytics_query)
            
            mock_request.assert_called_once_with(
                "POST",
                "/v1/analytics/funnel",
                json_data={"queries": sample_analytics_query}
            )
            assert result == {"errorcode": 0, "data": {}}
    
    def test_query_leads(self, analytics, sample_analytics_query):
        """Test query_leads method."""
        with patch.object(analytics.client, '_make_request') as mock_request:
            mock_request.return_value = {"errorcode": 0, "data": {}}
            
            result = analytics.query_leads(sample_analytics_query)
            
            mock_request.assert_called_once_with(
                "POST",
                "/v1/analytics/leads",
                json_data={"queries": sample_analytics_query}
            )
            assert result == {"errorcode": 0, "data": {}}
    
    def test_query_projects(self, analytics, sample_analytics_query):
        """Test query_projects method."""
        with patch.object(analytics.client, '_make_request') as mock_request:
            mock_request.return_value = {"errorcode": 0, "data": {}}
            
            result = analytics.query_projects(sample_analytics_query)
            
            mock_request.assert_called_once_with(
                "POST",
                "/v1/analytics/projects",
                json_data={"queries": sample_analytics_query}
            )
            assert result == {"errorcode": 0, "data": {}}
    
    def test_query_team_activity(self, analytics, sample_analytics_query):
        """Test query_team_activity method."""
        with patch.object(analytics.client, '_make_request') as mock_request:
            mock_request.return_value = {"errorcode": 0, "data": {}}
            
            result = analytics.query_team_activity(sample_analytics_query)
            
            mock_request.assert_called_once_with(
                "POST",
                "/v1/analytics/teamactivity",
                json_data={"queries": sample_analytics_query}
            )
            assert result == {"errorcode": 0, "data": {}}
    
    def test_get_team_activity_update(self, analytics):
        """Test get_team_activity_update method."""
        with patch.object(analytics.client, '_make_request') as mock_request:
            mock_request.return_value = {"errorcode": 0, "data": {}}
            
            result = analytics.get_team_activity_update()
            
            mock_request.assert_called_once_with(
                "GET",
                "/v1/analytics/teamactivity/update"
            )
            assert result == {"errorcode": 0, "data": {}}

