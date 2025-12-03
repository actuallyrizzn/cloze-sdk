# Python SDK Comprehensive Guide

Complete guide to using the Cloze Python SDK.

## Table of Contents

1. [Installation](#installation)
2. [Authentication](#authentication)
3. [Client Initialization](#client-initialization)
4. [API Endpoints](#api-endpoints)
5. [Error Handling](#error-handling)
6. [Advanced Usage](#advanced-usage)
7. [Testing](#testing)
8. [Best Practices](#best-practices)

## Installation

### From PyPI

```bash
pip install cloze-sdk
```

### From Source

```bash
git clone https://github.com/cloze/cloze-sdk
cd cloze-sdk/python
pip install -e .
```

### Development Setup

```bash
python -m venv venv
source venv/bin/activate  # or venv\Scripts\activate on Windows
pip install -r requirements-dev.txt
```

## Authentication

The Cloze API supports three authentication methods:

### 1. API Key (Simplest)

```python
from cloze_sdk import ClozeClient

client = ClozeClient(api_key="your_api_key_here")
```

### 2. OAuth 2.0 (Required for Public Integrations)

```python
client = ClozeClient(oauth_token="your_oauth_token_here")
```

### 3. Bearer Token (Alternative API Key Format)

The SDK automatically uses Bearer token format when using API keys.

## Client Initialization

### Basic Initialization

```python
from cloze_sdk import ClozeClient

# With API key
client = ClozeClient(api_key="your_api_key")

# With OAuth token
client = ClozeClient(oauth_token="your_oauth_token")

# Custom base URL (for testing)
client = ClozeClient(api_key="key", base_url="https://api-test.cloze.com")

# Custom timeout
client = ClozeClient(api_key="key", timeout=60)
```

## API Endpoints

### Analytics

Query activity, funnel, leads, projects, and team metrics.

```python
# Query user activity
activity = client.analytics.query_activity({
    "sentmails": {
        "period_scale": "month",
        "periods": 1
    },
    "meetings": {
        "period_scale": "week",
        "periods": 2
    }
})

# Query funnel
funnel = client.analytics.query_funnel({
    "my_funnel": {
        "period_scale": "month",
        "periods": 1
    }
})

# Query leads
leads = client.analytics.query_leads({
    "lead_query": {
        "period_scale": "quarter",
        "periods": 1
    }
})

# Query projects
projects = client.analytics.query_projects({
    "project_query": {
        "period_scale": "month",
        "periods": 1
    }
})

# Query team activity
team_activity = client.analytics.query_team_activity({
    "team_query": {
        "period_scale": "month",
        "periods": 1
    }
})

# Get team activity update status
update_status = client.analytics.get_team_activity_update()
```

### Team

Manage team members, nodes, and roles.

```python
# List team members
members = client.team.list_members()

# Update team members
result = client.team.update_members([
    {
        "id": "member_id",
        "role": "admin"
    }
])

# Get team nodes
nodes = client.team.get_nodes()

# Get team roles
roles = client.team.get_roles()
```

### Account

Access user profile, fields, segments, stages, steps, and views.

```python
# Get custom fields
fields = client.account.get_fields()
fields_person = client.account.get_fields(relationtype="person")

# Get user profile
profile = client.account.get_profile()

# Get segments
people_segments = client.account.get_segments_people()
project_segments = client.account.get_segments_projects()

# Get stages
people_stages = client.account.get_stages_people()
project_stages = client.account.get_stages_projects()

# Get steps
steps = client.account.get_steps()

# Get views
views = client.account.get_views()
```

### Projects

Full CRUD operations for projects.

```python
# Create project
project = client.projects.create({
    "name": "New Project",
    "description": "Project description"
})

# Update project
updated = client.projects.update({
    "id": "project_id",
    "name": "Updated Name"
})

# Get project
project = client.projects.get("project_id")
project = client.projects.get("project@example.com", identifier_type="email")

# Delete project
result = client.projects.delete("project_id")

# Find projects
projects = client.projects.find()
projects = client.projects.find(
    query={"segment": "active"},
    pagenumber=1,
    pagesize=10,
    countonly=False
)

# Feed (cursor-based pagination)
feed = client.projects.feed()
feed = client.projects.feed(
    cursor="next_cursor",
    segment="active",
    stage="in_progress",
    scope="team"
)
```

### People

Full CRUD operations for people/contacts.

```python
# Create person
person = client.people.create({
    "email": "john@example.com",
    "first": "John",
    "last": "Doe",
    "company": "Example Corp"
})

# Update person
updated = client.people.update({
    "id": "person_id",
    "first": "Jane"
})

# Get person
person = client.people.get("john@example.com")
person = client.people.get("person_id", identifier_type="id")

# Delete person
result = client.people.delete("john@example.com")

# Find people
people = client.people.find()
people = client.people.find(
    query={"segment": "lead"},
    pagenumber=1,
    pagesize=10,
    countonly=False
)

# Feed (cursor-based pagination)
feed = client.people.feed()
feed = client.people.feed(
    cursor="next_cursor",
    segment="lead",
    stage="warm",
    scope="local"
)
```

### Companies

Full CRUD operations for companies.

```python
# Create company
company = client.companies.create({
    "name": "Example Corp",
    "domain": "example.com"
})

# Update company
updated = client.companies.update({
    "id": "company_id",
    "name": "Updated Name"
})

# Get company
company = client.companies.get("example.com")
company = client.companies.get("company_id", identifier_type="id")

# Delete company
result = client.companies.delete("example.com")

# Find companies
companies = client.companies.find()
companies = client.companies.find(
    query={"segment": "customer"},
    pagenumber=1,
    pagesize=10,
    countonly=False
)

# Feed (cursor-based pagination)
feed = client.companies.feed()
feed = client.companies.feed(
    cursor="next_cursor",
    segment="customer",
    stage="active",
    scope="team"
)
```

### Timeline

Create timeline items and retrieve message opens.

```python
# Create communication
communication = client.timeline.create_communication({
    "type": "email",
    "subject": "Meeting Follow-up",
    "person": "john@example.com"
})

# Create content (note)
content = client.timeline.create_content({
    "type": "note",
    "text": "Important note",
    "person": "john@example.com"
})

# Create todo
todo = client.timeline.create_todo({
    "text": "Follow up with client",
    "due": 1234567890000,
    "person": "john@example.com"
})

# Get message opens
opens = client.timeline.get_message_opens()
opens = client.timeline.get_message_opens(
    from_timestamp=1234567890000,
    user="user@example.com"
)
```

### Webhooks

Manage webhook subscriptions.

```python
# List subscriptions
subscriptions = client.webhooks.list()

# Subscribe to events
subscription = client.webhooks.subscribe(
    event="person.change",
    target_url="https://your-app.com/webhook"
)

# Subscribe with filters and scope
subscription = client.webhooks.subscribe(
    event="person.audit.change",
    target_url="https://your-app.com/webhook",
    scope="local",
    filters=[
        {
            "person": {
                "segment": "lead"
            }
        }
    ],
    client_type="human",
    client_reference="my_subscription",
    ttl=3600
)

# Unsubscribe
result = client.webhooks.unsubscribe(
    event="person.change",
    uniqueid="subscription_id"
)

# Unsubscribe by client reference
result = client.webhooks.unsubscribe(
    event="person.change",
    client_reference="my_subscription"
)
```

## Error Handling

The SDK provides custom exceptions for different error types:

```python
from cloze_sdk import (
    ClozeAPIError,
    ClozeAuthenticationError,
    ClozeRateLimitError
)

try:
    result = client.account.get_profile()
except ClozeAuthenticationError as e:
    print(f"Authentication failed: {e}")
    # Handle authentication error
except ClozeRateLimitError as e:
    print(f"Rate limit exceeded: {e}")
    # Handle rate limit (may include retry logic)
except ClozeAPIError as e:
    print(f"API error: {e}")
    print(f"Error code: {e.errorcode}")
    # Handle general API error
except Exception as e:
    print(f"Unexpected error: {e}")
```

### Error Response Details

```python
try:
    result = client.people.get("invalid_id")
except ClozeAPIError as e:
    # Access error details
    print(f"Message: {e}")
    print(f"Error code: {e.errorcode}")
    print(f"Response: {e.response}")
```

## Advanced Usage

### Custom Request Parameters

```python
# Use API key as query parameter (instead of Bearer token)
result = client._make_request(
    "GET",
    "/v1/user/profile",
    use_api_key_param=True
)
```

### Handling Pagination

```python
# Using find() with pagination
page = 1
page_size = 50
all_results = []

while True:
    results = client.people.find(
        query={"segment": "lead"},
        pagenumber=page,
        pagesize=page_size
    )
    
    all_results.extend(results.get("list", []))
    
    if len(results.get("list", [])) < page_size:
        break
    
    page += 1

# Using feed() with cursor-based pagination
cursor = None
all_items = []

while True:
    feed = client.people.feed(cursor=cursor)
    all_items.extend(feed.get("list", []))
    
    cursor = feed.get("cursor")
    if not cursor:
        break
```

### Batch Operations

```python
# Create multiple people
people_data = [
    {"email": "person1@example.com", "first": "Person", "last": "One"},
    {"email": "person2@example.com", "first": "Person", "last": "Two"},
    {"email": "person3@example.com", "first": "Person", "last": "Three"}
]

created = []
for person_data in people_data:
    try:
        result = client.people.create(person_data)
        created.append(result)
    except ClozeAPIError as e:
        print(f"Failed to create {person_data['email']}: {e}")
```

## Testing

See [`../python/TESTING.md`](../python/TESTING.md) for comprehensive testing documentation.

### Running Tests

```bash
# Unit tests (100% coverage)
pytest -m "not integration and not e2e"

# Integration tests (requires CLOZE_API_KEY)
pytest -m integration

# E2E tests (requires CLOZE_API_KEY)
pytest -m e2e
```

## Best Practices

1. **Use Environment Variables for API Keys**
   ```python
   import os
   client = ClozeClient(api_key=os.getenv("CLOZE_API_KEY"))
   ```

2. **Handle Rate Limits Gracefully**
   ```python
   import time
   
   try:
       result = client.account.get_profile()
   except ClozeRateLimitError:
       time.sleep(60)  # Wait before retry
       result = client.account.get_profile()
   ```

3. **Use Pagination for Large Datasets**
   - Use `find()` for query-based pagination
   - Use `feed()` for cursor-based bulk retrieval

4. **Validate Data Before Sending**
   ```python
   person_data = {
       "email": "john@example.com",
       "first": "John",
       "last": "Doe"
   }
   # Validate email format, required fields, etc.
   result = client.people.create(person_data)
   ```

5. **Use Webhooks for Real-time Updates**
   - Subscribe to relevant events
   - Handle webhook notifications securely
   - Unsubscribe when no longer needed

6. **Error Handling**
   - Always catch specific exceptions
   - Log errors for debugging
   - Implement retry logic for transient errors

## License

AGPLv3 - See [`../LICENSE-CODE`](../LICENSE-CODE) for details.

