"""Companies endpoints for the Cloze API."""

from typing import Dict, Any, Optional


class Companies:
    """Companies endpoints."""
    
    def __init__(self, client):
        self.client = client
    
    def create(self, company: Dict[str, Any]) -> Dict[str, Any]:
        """
        Create a new company or enhance an existing one.
        
        Args:
            company: Company data to create
            
        Returns:
            Creation result
        """
        return self.client._make_request(
            "POST",
            "/v1/companies/create",
            json_data=company
        )
    
    def update(self, company: Dict[str, Any]) -> Dict[str, Any]:
        """
        Enhance an existing company.
        
        Args:
            company: Company data to update
            
        Returns:
            Update result
        """
        return self.client._make_request(
            "POST",
            "/v1/companies/update",
            json_data=company
        )
    
    def get(self, identifier: str, identifier_type: Optional[str] = None) -> Dict[str, Any]:
        """
        Get a company by identifier.
        
        Args:
            identifier: Unique identifier (domain, twitter, email, direct ID, etc.)
            identifier_type: Optional type of identifier
            
        Returns:
            Company data
        """
        params = {"identifier": identifier}
        if identifier_type:
            params["identifier_type"] = identifier_type
        
        return self.client._make_request(
            "GET",
            "/v1/companies/get",
            params=params
        )
    
    def delete(self, identifier: str, identifier_type: Optional[str] = None) -> Dict[str, Any]:
        """
        Delete a company.
        
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
            "/v1/companies/delete",
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
        Find companies with extensive query, sort and group by options.
        
        Args:
            query: Query parameters
            pagenumber: Page number for pagination
            pagesize: Page size for pagination
            countonly: If True, return only count
            **kwargs: Additional query parameters
            
        Returns:
            List of matching companies or count
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
            "/v1/companies/find",
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
        Bulk retrieval of company records with cursor-based pagination.
        
        Args:
            cursor: Cursor from previous request for pagination
            segment: Filter by segment
            stage: Filter by stage
            scope: Filter by scope (team, local, etc.)
            **kwargs: Additional parameters
            
        Returns:
            Company records and next cursor
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
            "/v1/companies/feed",
            params=params
        )

