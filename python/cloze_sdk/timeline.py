"""Timeline endpoints for the Cloze API."""

from typing import Dict, Any, Optional


class Timeline:
    """Timeline endpoints."""
    
    def __init__(self, client):
        self.client = client
    
    def create_communication(self, communication: Dict[str, Any]) -> Dict[str, Any]:
        """
        Create a communication timeline item.
        
        Args:
            communication: Communication data
            
        Returns:
            Creation result
        """
        return self.client._make_request(
            "POST",
            "/v1/timeline/communication/create",
            json_data=communication
        )
    
    def create_content(self, content: Dict[str, Any]) -> Dict[str, Any]:
        """
        Create a content timeline item.
        
        Args:
            content: Content data
            
        Returns:
            Creation result
        """
        return self.client._make_request(
            "POST",
            "/v1/timeline/content/create",
            json_data=content
        )
    
    def create_todo(self, todo: Dict[str, Any]) -> Dict[str, Any]:
        """
        Create a todo timeline item.
        
        Args:
            todo: Todo data
            
        Returns:
            Creation result
        """
        return self.client._make_request(
            "POST",
            "/v1/timeline/todo/create",
            json_data=todo
        )
    
    def get_message_opens(
        self,
        from_timestamp: Optional[int] = None,
        user: Optional[str] = None
    ) -> Dict[str, Any]:
        """
        Retrieve email opens.
        
        Args:
            from_timestamp: UTC ms timestamp for first message to retrieve
            user: User identifier
            
        Returns:
            Message opens data
        """
        params = {}
        if from_timestamp is not None:
            params["from"] = from_timestamp
        if user:
            params["user"] = user
        
        return self.client._make_request(
            "GET",
            "/v1/messages/opens",
            params=params
        )

