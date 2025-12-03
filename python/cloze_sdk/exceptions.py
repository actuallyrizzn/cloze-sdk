"""Custom exceptions for the Cloze SDK."""


class ClozeAPIError(Exception):
    """Base exception for all Cloze API errors."""
    
    def __init__(self, message, errorcode=None, response=None):
        super().__init__(message)
        self.errorcode = errorcode
        self.response = response


class ClozeAuthenticationError(ClozeAPIError):
    """Raised when authentication fails."""
    pass


class ClozeRateLimitError(ClozeAPIError):
    """Raised when rate limit is exceeded."""
    pass


class ClozeValidationError(ClozeAPIError):
    """Raised when request validation fails."""
    pass

