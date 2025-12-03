"""
Cloze Python SDK

A comprehensive Python SDK for the Cloze API.
"""

from .client import ClozeClient
from .exceptions import ClozeAPIError, ClozeAuthenticationError, ClozeRateLimitError

__version__ = "1.0.0"
__all__ = [
    "ClozeClient",
    "ClozeAPIError",
    "ClozeAuthenticationError",
    "ClozeRateLimitError",
]

