"""Analytics endpoints for the Cloze API."""

from typing import Dict, Any, Optional


class Analytics:
    """Analytics endpoints."""
    
    def __init__(self, client):
        self.client = client
    
    def query_activity(self, queries: Dict[str, Any]) -> Dict[str, Any]:
        """
        Query user activity.
        
        Args:
            queries: Map of Query definitions. The response will be organized by the query names.
            
        Returns:
            Activity data for individual reporting periods
        """
        return self.client._make_request(
            "POST",
            "/v1/analytics/activity",
            json_data={"queries": queries}
        )
    
    def query_funnel(self, queries: Dict[str, Any]) -> Dict[str, Any]:
        """
        Query funnel information (BETA).
        
        Args:
            queries: Map of FunnelQuery definitions.
            
        Returns:
            Funnel data
        """
        return self.client._make_request(
            "POST",
            "/v1/analytics/funnel",
            json_data={"queries": queries}
        )
    
    def query_leads(self, queries: Dict[str, Any]) -> Dict[str, Any]:
        """
        Query lead analytics.
        
        Args:
            queries: Map of Query definitions for leads.
            
        Returns:
            Lead analytics data
        """
        return self.client._make_request(
            "POST",
            "/v1/analytics/leads",
            json_data={"queries": queries}
        )
    
    def query_projects(self, queries: Dict[str, Any]) -> Dict[str, Any]:
        """
        Query project analytics.
        
        Args:
            queries: Map of ProjectQuery definitions.
            
        Returns:
            Project analytics data
        """
        return self.client._make_request(
            "POST",
            "/v1/analytics/projects",
            json_data={"queries": queries}
        )
    
    def query_team_activity(self, queries: Dict[str, Any]) -> Dict[str, Any]:
        """
        Query team activity.
        
        Args:
            queries: Map of Query definitions for team activity.
            
        Returns:
            Team activity data
        """
        return self.client._make_request(
            "POST",
            "/v1/analytics/teamactivity",
            json_data={"queries": queries}
        )
    
    def get_team_activity_update(self) -> Dict[str, Any]:
        """
        Get team activity update status.
        
        Returns:
            Team activity update information
        """
        return self.client._make_request(
            "GET",
            "/v1/analytics/teamactivity/update"
        )

