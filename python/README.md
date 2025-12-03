# Cloze Python SDK

Python SDK for the Cloze API with 100% endpoint coverage.

## Installation

### Using pip

```bash
pip install cloze-sdk
```

### From source

```bash
git clone https://github.com/cloze/cloze-sdk-python
cd cloze-sdk-python
pip install -e .
```

### Development Setup

```bash
# Create virtual environment
python -m venv venv

# Activate virtual environment
# On Windows:
venv\Scripts\activate
# On macOS/Linux:
source venv/bin/activate

# Install dependencies
pip install -r requirements.txt
pip install -r requirements-dev.txt
```

## Quick Start

```python
from cloze_sdk import ClozeClient

# Initialize client with API key
client = ClozeClient(api_key="your_api_key_here")

# Or with OAuth token
client = ClozeClient(oauth_token="your_oauth_token_here")

# Get user profile
profile = client.account.get_profile()
print(profile)

# Query analytics
activity = client.analytics.query_activity({
    "my_query": {
        "max": 30,
        "scale": "month",
        "measures": ["sentmails", "meetings"]
    }
})

# Create a person
person = client.people.create({
    "email": "john@example.com",
    "first": "John",
    "last": "Doe"
})

# Subscribe to webhooks
subscription = client.webhooks.subscribe(
    event="person.audit.change",
    target_url="https://your-app.com/webhook",
    scope="local"
)
```

## API Coverage

This SDK provides 100% coverage of all Cloze API endpoints:

### Analytics (6 endpoints)
- `query_activity()` - Query user activity
- `query_funnel()` - Query funnel information
- `query_leads()` - Query lead analytics
- `query_projects()` - Query project analytics
- `query_team_activity()` - Query team activity
- `get_team_activity_update()` - Get team activity update status

### Team (4 endpoints)
- `list_members()` - List team members
- `update_members()` - Update team members
- `get_nodes()` - Get team organizational nodes
- `get_roles()` - Get team roles

### Account (7 endpoints)
- `get_fields()` - Get custom fields
- `get_profile()` - Get user profile
- `get_segments_people()` - Get people contact segments
- `get_segments_projects()` - Get project segments
- `get_stages_people()` - Get people contact stages
- `get_stages_projects()` - Get project stages
- `get_steps()` - Get steps
- `get_views()` - Get views and audiences

### Projects (6 endpoints)
- `create()` - Create a project
- `update()` - Update a project
- `get()` - Get a project
- `delete()` - Delete a project
- `find()` - Find projects
- `feed()` - Bulk retrieval with pagination

### People (6 endpoints)
- `create()` - Create a person
- `update()` - Update a person
- `get()` - Get a person
- `delete()` - Delete a person
- `find()` - Find people
- `feed()` - Bulk retrieval with pagination

### Companies (6 endpoints)
- `create()` - Create a company
- `update()` - Update a company
- `get()` - Get a company
- `delete()` - Delete a company
- `find()` - Find companies
- `feed()` - Bulk retrieval with pagination

### Timeline (4 endpoints)
- `create_communication()` - Create communication timeline item
- `create_content()` - Create content timeline item
- `create_todo()` - Create todo timeline item
- `get_message_opens()` - Retrieve email opens

### Webhooks (3 endpoints)
- `list()` - List webhook subscriptions
- `subscribe()` - Subscribe to change events
- `unsubscribe()` - Cancel a subscription

## Authentication

The SDK supports three authentication methods:

1. **API Key** (simplest for development)
   ```python
   client = ClozeClient(api_key="your_api_key")
   ```

2. **OAuth 2.0** (required for public integrations)
   ```python
   client = ClozeClient(oauth_token="your_oauth_token")
   ```

3. **Bearer Token** (alternative API key format)
   ```python
   client = ClozeClient(api_key="your_api_key")  # Uses bearer token format
   ```

## Error Handling

The SDK provides custom exceptions:

```python
from cloze_sdk import ClozeAPIError, ClozeAuthenticationError, ClozeRateLimitError

try:
    result = client.account.get_profile()
except ClozeAuthenticationError:
    print("Authentication failed")
except ClozeRateLimitError:
    print("Rate limit exceeded")
except ClozeAPIError as e:
    print(f"API error: {e}")
```

## Examples

See the `examples/` directory for more detailed examples.

## Documentation

Full API documentation is available at: https://developer.cloze.com/

## License

MIT License

## Support

For issues and questions:
- GitHub Issues: https://github.com/cloze/cloze-sdk-python/issues
- Email: support@cloze.com

