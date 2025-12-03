"""Webhooks endpoints for the Cloze API."""

from typing import Dict, Any, Optional, List


class Webhooks:
    """Webhooks endpoints."""
    
    def __init__(self, client):
        self.client = client
    
    def list(self) -> Dict[str, Any]:
        """
        List all webhook subscriptions.
        
        Returns:
            List of webhook subscriptions
        """
        return self.client._make_request(
            "GET",
            "/v1/webhooks"
        )
    
    def subscribe(
        self,
        event: str,
        target_url: str,
        scope: Optional[str] = None,
        filters: Optional[List[Dict[str, Any]]] = None,
        client_type: Optional[str] = None,
        client_reference: Optional[str] = None,
        ttl: Optional[int] = None
    ) -> Dict[str, Any]:
        """
        Subscribe to change events.
        
        Args:
            event: Event type (person.change, project.change, company.change, 
                   person.audit.change, project.audit.change, company.audit.change)
            target_url: Callback URL for webhook notifications
            scope: Subscription scope (local, team, hierarchy:/X/Y/Z, hierarchy:/X/Y/Z/*)
            filters: List of filter objects for filtering notifications
            client_type: Optional client implementation information (e.g., "human")
            client_reference: Optional client-provided name for the subscription
            ttl: Optional time-to-live for subscription in seconds
            
        Returns:
            Subscription information with uniqueid
        """
        subscription = {
            "event": event,
            "target_url": target_url
        }
        
        if scope:
            subscription["scope"] = scope
        if filters:
            subscription["filters"] = filters
        if client_type:
            subscription["client_type"] = client_type
        if client_reference:
            subscription["client_reference"] = client_reference
        if ttl:
            subscription["ttl"] = str(ttl)
        
        return self.client._make_request(
            "POST",
            "/v1/webhooks/subscribe",
            json_data=subscription
        )
    
    def unsubscribe(
        self,
        event: str,
        uniqueid: Optional[str] = None,
        client_reference: Optional[str] = None
    ) -> Dict[str, Any]:
        """
        Cancel a webhook subscription.
        
        Args:
            event: Event type of the subscription to cancel
            uniqueid: Unique subscription identifier (use with event)
            client_reference: Client subscription reference (use with event if provided during subscribe)
            
        Returns:
            Unsubscribe result
        """
        if not uniqueid and not client_reference:
            raise ValueError("Either uniqueid or client_reference must be provided")
        
        subscription = {"event": event}
        if uniqueid:
            subscription["uniqueid"] = uniqueid
        if client_reference:
            subscription["client_reference"] = client_reference
        
        return self.client._make_request(
            "POST",
            "/v1/webhooks/unsubscribe",
            json_data=subscription
        )

