"""Team endpoints for the Cloze API."""

from typing import Dict, Any, Optional, List


class Team:
    """Team endpoints."""
    
    def __init__(self, client):
        self.client = client
    
    def list_members(self) -> Dict[str, Any]:
        """
        List team members.
        
        Returns:
            List of team members
        """
        return self.client._make_request(
            "GET",
            "/v1/team/members/list"
        )
    
    def update_members(self, members: List[Dict[str, Any]]) -> Dict[str, Any]:
        """
        Update team members.
        
        Args:
            members: List of team member updates.
            
        Returns:
            Update result
        """
        return self.client._make_request(
            "POST",
            "/v1/team/members/update",
            json_data={"members": members}
        )
    
    def get_nodes(self) -> Dict[str, Any]:
        """
        Get team organizational nodes.
        
        Returns:
            Team nodes structure
        """
        return self.client._make_request(
            "GET",
            "/v1/team/nodes"
        )
    
    def get_roles(self) -> Dict[str, Any]:
        """
        Get team roles.
        
        Returns:
            List of team roles with names and IDs
        """
        return self.client._make_request(
            "GET",
            "/v1/team/roles"
        )

