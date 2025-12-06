"""
Timeline endpoints for the Cloze API.

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

from typing import Dict, Any, Optional, Union


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
            "POST", "/v1/timeline/communication/create", json_data=communication
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
            "POST", "/v1/timeline/content/create", json_data=content
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
            "POST", "/v1/timeline/todo/create", json_data=todo
        )

    def get_message_opens(
        self, from_timestamp: Optional[int] = None, user: Optional[str] = None
    ) -> Dict[str, Any]:
        """
        Retrieve email opens.

        Args:
            from_timestamp: UTC ms timestamp for first message to retrieve
            user: User identifier

        Returns:
            Message opens data
        """
        params: Dict[str, Union[int, str]] = {}
        if from_timestamp is not None:
            params["from"] = from_timestamp
        if user:
            params["user"] = user

        return self.client._make_request("GET", "/v1/messages/opens", params=params)
