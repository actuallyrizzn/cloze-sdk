"""Projects endpoints for the Cloze API."""

from typing import Dict, Any, Optional


class Projects:
    """Projects endpoints."""
    
    def __init__(self, client):
        self.client = client
    
    def create(self, project: Dict[str, Any]) -> Dict[str, Any]:
        """
        Create a new project or merge updates into an existing one.
        
        Args:
            project: Project data to create
            
        Returns:
            Creation result
        """
        return self.client._make_request(
            "POST",
            "/v1/projects/create",
            json_data=project
        )
    
    def update(self, project: Dict[str, Any]) -> Dict[str, Any]:
        """
        Merge updates into an existing project.
        
        Args:
            project: Project data to update
            
        Returns:
            Update result
        """
        return self.client._make_request(
            "POST",
            "/v1/projects/update",
            json_data=project
        )
    
    def get(self, identifier: str, identifier_type: Optional[str] = None) -> Dict[str, Any]:
        """
        Get a project by identifier.
        
        Args:
            identifier: Unique identifier (email, twitter, direct ID, etc.)
            identifier_type: Optional type of identifier
            
        Returns:
            Project data
        """
        params = {"identifier": identifier}
        if identifier_type:
            params["identifier_type"] = identifier_type
        
        return self.client._make_request(
            "GET",
            "/v1/projects/get",
            params=params
        )
    
    def delete(self, identifier: str, identifier_type: Optional[str] = None) -> Dict[str, Any]:
        """
        Delete a project.
        
        Args:
            identifier: Unique identifier
            identifier_type: Optional type of identifier
            
        Returns:
            Deletion result
        """
        params = {"identifier": identifier}
        if identifier_type:
            params["identifier_type"] = identifier_type
        
        return self.client._make_request(
            "DELETE",
            "/v1/projects/delete",
            params=params
        )
    
    def find(
        self,
        query: Optional[Dict[str, Any]] = None,
        pagenumber: Optional[int] = None,
        pagesize: Optional[int] = None,
        countonly: Optional[bool] = None,
        **kwargs
    ) -> Dict[str, Any]:
        """
        Find projects with extensive query, sort and group by options.
        
        Args:
            query: Query parameters
            pagenumber: Page number for pagination
            pagesize: Page size for pagination
            countonly: If True, return only count
            **kwargs: Additional query parameters
            
        Returns:
            List of matching projects or count
        """
        params = kwargs.copy()
        if query:
            params.update(query)
        if pagenumber is not None:
            params["pagenumber"] = pagenumber
        if pagesize is not None:
            params["pagesize"] = pagesize
        if countonly is not None:
            params["countonly"] = countonly
        
        return self.client._make_request(
            "GET",
            "/v1/projects/find",
            params=params
        )
    
    def feed(
        self,
        cursor: Optional[str] = None,
        segment: Optional[str] = None,
        stage: Optional[str] = None,
        scope: Optional[str] = None,
        **kwargs
    ) -> Dict[str, Any]:
        """
        Bulk retrieval of project records with cursor-based pagination.
        
        Args:
            cursor: Cursor from previous request for pagination
            segment: Filter by segment
            stage: Filter by stage
            scope: Filter by scope (team, local, etc.)
            **kwargs: Additional parameters
            
        Returns:
            Project records and next cursor
        """
        params = kwargs.copy()
        if cursor:
            params["cursor"] = cursor
        if segment:
            params["segment"] = segment
        if stage:
            params["stage"] = stage
        if scope:
            params["scope"] = scope
        
        return self.client._make_request(
            "GET",
            "/v1/projects/feed",
            params=params
        )

