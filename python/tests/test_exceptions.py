"""Unit tests for exception classes."""

import pytest
from cloze_sdk.exceptions import (
    ClozeAPIError,
    ClozeAuthenticationError,
    ClozeRateLimitError,
    ClozeValidationError
)
from unittest.mock import Mock


class TestExceptions:
    """Test exception classes."""
    
    def test_cloze_api_error(self):
        """Test ClozeAPIError."""
        error = ClozeAPIError("Test error", errorcode=1)
        assert str(error) == "Test error"
        assert error.errorcode == 1
        assert error.response is None
    
    def test_cloze_api_error_with_response(self):
        """Test ClozeAPIError with response."""
        response = Mock()
        error = ClozeAPIError("Test error", errorcode=1, response=response)
        assert error.response == response
    
    def test_cloze_api_error_init_calls_super(self):
        """Test that ClozeAPIError.__init__ properly calls super().__init__."""
        error = ClozeAPIError("Test message")
        # Verify the exception message is set
        assert str(error) == "Test message"
        # Verify attributes are set
        assert error.errorcode is None
        assert error.response is None
        
        # Test with all parameters
        response = Mock()
        error2 = ClozeAPIError("Test", errorcode=5, response=response)
        assert error2.errorcode == 5
        assert error2.response == response
    
    def test_cloze_authentication_error(self):
        """Test ClozeAuthenticationError."""
        error = ClozeAuthenticationError("Auth failed")
        assert isinstance(error, ClozeAPIError)
        assert str(error) == "Auth failed"
    
    def test_cloze_rate_limit_error(self):
        """Test ClozeRateLimitError."""
        error = ClozeRateLimitError("Rate limit exceeded")
        assert isinstance(error, ClozeAPIError)
        assert str(error) == "Rate limit exceeded"
    
    def test_cloze_validation_error(self):
        """Test ClozeValidationError."""
        error = ClozeValidationError("Validation failed")
        assert isinstance(error, ClozeAPIError)
        assert str(error) == "Validation failed"

