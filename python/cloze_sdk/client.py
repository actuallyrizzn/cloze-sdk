"""
Base client for Cloze API interactions.

Copyright (C) 2025 Cloze SDK Contributors

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU Affero General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU Affero General Public License for more details.

You should have received a copy of the GNU Affero General Public License
along with this program.  If not, see <https://www.gnu.org/licenses/>.
"""

import requests
from typing import Optional, Dict, Any
from .exceptions import ClozeAPIError, ClozeAuthenticationError, ClozeRateLimitError


class ClozeClient:
    """Main client for interacting with the Cloze API."""

    BASE_URL = "https://api.cloze.com"
    API_VERSION = "2025.10"

    def __init__(
        self,
        api_key: Optional[str] = None,
        oauth_token: Optional[str] = None,
        base_url: Optional[str] = None,
        timeout: int = 30,
    ):
        """
        Initialize the Cloze client.

        Args:
            api_key: API key for authentication (can be used as query param or bearer token)
            oauth_token: OAuth 2.0 access token
            base_url: Custom base URL (defaults to https://api.cloze.com)
            timeout: Request timeout in seconds (default: 30)
        """
        if not api_key and not oauth_token:
            raise ValueError("Either api_key or oauth_token must be provided")

        self.api_key = api_key
        self.oauth_token = oauth_token
        self.base_url = base_url or self.BASE_URL
        self.timeout = timeout

        self.session = requests.Session()
        self._setup_session()

        # Initialize endpoint modules
        from .analytics import Analytics
        from .team import Team
        from .account import Account
        from .projects import Projects
        from .people import People
        from .companies import Companies
        from .timeline import Timeline
        from .webhooks import Webhooks

        self.analytics = Analytics(self)
        self.team = Team(self)
        self.account = Account(self)
        self.projects = Projects(self)
        self.people = People(self)
        self.companies = Companies(self)
        self.timeline = Timeline(self)
        self.webhooks = Webhooks(self)

    def _setup_session(self):
        """Configure the requests session with default headers."""
        self.session.headers.update(
            {
                "Accept": "application/json",
                "Content-Type": "application/json",
                "User-Agent": f"cloze-sdk-python/{__import__('cloze_sdk').__version__}",
            }
        )

        # Set authentication
        if self.oauth_token:
            self.session.headers["Authorization"] = f"Bearer {self.oauth_token}"
        elif self.api_key:
            # Use bearer token format by default
            self.session.headers["Authorization"] = f"Bearer {self.api_key}"

    def _make_request(
        self,
        method: str,
        endpoint: str,
        params: Optional[Dict[str, Any]] = None,
        data: Optional[Dict[str, Any]] = None,
        json_data: Optional[Dict[str, Any]] = None,
        use_api_key_param: bool = False,
    ) -> Dict[str, Any]:
        """
        Make an HTTP request to the Cloze API.

        Args:
            method: HTTP method (GET, POST, DELETE, etc.)
            endpoint: API endpoint path (e.g., '/v1/user/profile')
            params: Query parameters
            data: Form data
            json_data: JSON body data
            use_api_key_param: If True, add api_key as query parameter instead of header

        Returns:
            Response JSON data

        Raises:
            ClozeAPIError: For API errors
            ClozeAuthenticationError: For authentication errors
            ClozeRateLimitError: For rate limit errors
        """
        url = f"{self.base_url}{endpoint}"

        # Prepare query parameters
        request_params = params or {}
        if use_api_key_param and self.api_key and not self.oauth_token:
            request_params["api_key"] = self.api_key

        # Prepare request kwargs
        request_kwargs = {
            "method": method,
            "url": url,
            "params": request_params,
            "timeout": self.timeout,
        }

        if json_data:
            request_kwargs["json"] = json_data
        elif data:
            request_kwargs["data"] = data

        try:
            response = self.session.request(**request_kwargs)  # type: ignore[arg-type]
            return self._handle_response(response)
        except requests.exceptions.RequestException as e:
            raise ClozeAPIError(f"Request failed: {str(e)}")

    def _handle_response(self, response: requests.Response) -> Dict[str, Any]:
        """
        Handle API response and raise appropriate exceptions.

        Args:
            response: Requests response object

        Returns:
            Response JSON data

        Raises:
            ClozeAPIError: For API errors
            ClozeAuthenticationError: For authentication errors
            ClozeRateLimitError: For rate limit errors
        """
        # Handle rate limiting
        if response.status_code == 429:
            raise ClozeRateLimitError("Rate limit exceeded", response=response)

        # Handle authentication errors
        if response.status_code == 401:
            raise ClozeAuthenticationError(
                "Authentication failed. Check your API key or OAuth token.",
                response=response,
            )

        # Parse JSON response
        try:
            data = response.json()
        except ValueError:
            # If response is not JSON, raise with status code
            raise ClozeAPIError(
                f"Invalid response format. Status: {response.status_code}",
                response=response,
            )

        # Check for API errors in response
        errorcode = data.get("errorcode", 0)
        if errorcode != 0:
            message = data.get("message", "Unknown API error")
            raise ClozeAPIError(
                f"API error: {message}", errorcode=errorcode, response=response
            )

        # Return successful response
        return data
