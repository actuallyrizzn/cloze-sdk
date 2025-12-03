# PHP SDK Comprehensive Guide

Complete guide to using the Cloze PHP SDK.

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

### Using Composer

```bash
composer require cloze/cloze-sdk-php
```

### Manual Installation

```bash
git clone https://github.com/cloze/cloze-sdk
cd cloze-sdk/php
composer install
```

## Authentication

The Cloze API supports three authentication methods:

### 1. API Key (Simplest)

```php
use Cloze\SDK\ClozeClient;

$client = new ClozeClient('your_api_key_here');
```

### 2. OAuth 2.0 (Required for Public Integrations)

```php
$client = new ClozeClient(null, 'your_oauth_token_here');
```

### 3. Bearer Token (Alternative API Key Format)

The SDK automatically uses Bearer token format when using API keys.

## Client Initialization

### Basic Initialization

```php
use Cloze\SDK\ClozeClient;

// With API key
$client = new ClozeClient('your_api_key');

// With OAuth token
$client = new ClozeClient(null, 'your_oauth_token');

// Custom base URL (for testing)
$client = new ClozeClient('key', null, 'https://api-test.cloze.com');

// Custom timeout
$client = new ClozeClient('key', null, null, 60);
```

## API Endpoints

### Analytics

Query activity, funnel, leads, projects, and team metrics.

```php
// Query user activity
$activity = $client->analytics->queryActivity([
    'sentmails' => [
        'period_scale' => 'month',
        'periods' => 1
    ],
    'meetings' => [
        'period_scale' => 'week',
        'periods' => 2
    ]
]);

// Query funnel
$funnel = $client->analytics->queryFunnel([
    'my_funnel' => [
        'period_scale' => 'month',
        'periods' => 1
    ]
]);

// Query leads
$leads = $client->analytics->queryLeads([
    'lead_query' => [
        'period_scale' => 'quarter',
        'periods' => 1
    ]
]);

// Query projects
$projects = $client->analytics->queryProjects([
    'project_query' => [
        'period_scale' => 'month',
        'periods' => 1
    ]
]);

// Query team activity
$teamActivity = $client->analytics->queryTeamActivity([
    'team_query' => [
        'period_scale' => 'month',
        'periods' => 1
    ]
]);

// Get team activity update status
$updateStatus = $client->analytics->getTeamActivityUpdate();
```

### Team

Manage team members, nodes, and roles.

```php
// List team members
$members = $client->team->listMembers();

// Update team members
$result = $client->team->updateMembers([
    [
        'id' => 'member_id',
        'role' => 'admin'
    ]
]);

// Get team nodes
$nodes = $client->team->getNodes();

// Get team roles
$roles = $client->team->getRoles();
```

### Account

Access user profile, fields, segments, stages, steps, and views.

```php
// Get custom fields
$fields = $client->account->getFields();
$fieldsPerson = $client->account->getFields('person');

// Get user profile
$profile = $client->account->getProfile();

// Get segments
$peopleSegments = $client->account->getSegmentsPeople();
$projectSegments = $client->account->getSegmentsProjects();

// Get stages
$peopleStages = $client->account->getStagesPeople();
$projectStages = $client->account->getStagesProjects();

// Get steps
$steps = $client->account->getSteps();

// Get views
$views = $client->account->getViews();
```

### Projects

Full CRUD operations for projects.

```php
// Create project
$project = $client->projects->create([
    'name' => 'New Project',
    'description' => 'Project description'
]);

// Update project
$updated = $client->projects->update([
    'id' => 'project_id',
    'name' => 'Updated Name'
]);

// Get project
$project = $client->projects->get('project_id');
$project = $client->projects->get('project@example.com', 'email');

// Delete project
$result = $client->projects->delete('project_id');

// Find projects
$projects = $client->projects->find();
$projects = $client->projects->find(
    ['segment' => 'active'],
    1,
    10,
    false
);

// Feed (cursor-based pagination)
$feed = $client->projects->feed();
$feed = $client->projects->feed(
    'next_cursor',
    'active',
    'in_progress',
    'team'
);
```

### People

Full CRUD operations for people/contacts.

```php
// Create person
$person = $client->people->create([
    'email' => 'john@example.com',
    'first' => 'John',
    'last' => 'Doe',
    'company' => 'Example Corp'
]);

// Update person
$updated = $client->people->update([
    'id' => 'person_id',
    'first' => 'Jane'
]);

// Get person
$person = $client->people->get('john@example.com');
$person = $client->people->get('person_id', 'id');

// Delete person
$result = $client->people->delete('john@example.com');

// Find people
$people = $client->people->find();
$people = $client->people->find(
    ['segment' => 'lead'],
    1,
    10,
    false
);

// Feed (cursor-based pagination)
$feed = $client->people->feed();
$feed = $client->people->feed(
    'next_cursor',
    'lead',
    'warm',
    'local'
);
```

### Companies

Full CRUD operations for companies.

```php
// Create company
$company = $client->companies->create([
    'name' => 'Example Corp',
    'domain' => 'example.com'
]);

// Update company
$updated = $client->companies->update([
    'id' => 'company_id',
    'name' => 'Updated Name'
]);

// Get company
$company = $client->companies->get('example.com');
$company = $client->companies->get('company_id', 'id');

// Delete company
$result = $client->companies->delete('example.com');

// Find companies
$companies = $client->companies->find();
$companies = $client->companies->find(
    ['segment' => 'customer'],
    1,
    10,
    false
);

// Feed (cursor-based pagination)
$feed = $client->companies->feed();
$feed = $client->companies->feed(
    'next_cursor',
    'customer',
    'active',
    'team'
);
```

### Timeline

Create timeline items and retrieve message opens.

```php
// Create communication
$communication = $client->timeline->createCommunication([
    'type' => 'email',
    'subject' => 'Meeting Follow-up',
    'person' => 'john@example.com'
]);

// Create content (note)
$content = $client->timeline->createContent([
    'type' => 'note',
    'text' => 'Important note',
    'person' => 'john@example.com'
]);

// Create todo
$todo = $client->timeline->createTodo([
    'text' => 'Follow up with client',
    'due' => 1234567890000,
    'person' => 'john@example.com'
]);

// Get message opens
$opens = $client->timeline->getMessageOpens();
$opens = $client->timeline->getMessageOpens(
    1234567890000,
    'user@example.com'
);
```

### Webhooks

Manage webhook subscriptions.

```php
// List subscriptions
$subscriptions = $client->webhooks->list();

// Subscribe to events
$subscription = $client->webhooks->subscribe(
    'person.change',
    'https://your-app.com/webhook'
);

// Subscribe with filters and scope
$subscription = $client->webhooks->subscribe(
    'person.audit.change',
    'https://your-app.com/webhook',
    'local',
    [
        [
            'person' => [
                'segment' => 'lead'
            ]
        ]
    ],
    'human',
    'my_subscription',
    3600
);

// Unsubscribe
$result = $client->webhooks->unsubscribe(
    'person.change',
    'subscription_id'
);

// Unsubscribe by client reference
$result = $client->webhooks->unsubscribe(
    'person.change',
    null,
    'my_subscription'
);
```

## Error Handling

The SDK provides custom exceptions for different error types:

```php
use Cloze\SDK\Exceptions\ClozeAPIError;
use Cloze\SDK\Exceptions\ClozeAuthenticationError;
use Cloze\SDK\Exceptions\ClozeRateLimitError;

try {
    $result = $client->account->getProfile();
} catch (ClozeAuthenticationError $e) {
    echo "Authentication failed: " . $e->getMessage() . "\n";
    // Handle authentication error
} catch (ClozeRateLimitError $e) {
    echo "Rate limit exceeded: " . $e->getMessage() . "\n";
    // Handle rate limit (may include retry logic)
} catch (ClozeAPIError $e) {
    echo "API error: " . $e->getMessage() . "\n";
    echo "Error code: " . $e->getErrorcode() . "\n";
    // Handle general API error
} catch (\Exception $e) {
    echo "Unexpected error: " . $e->getMessage() . "\n";
}
```

### Error Response Details

```php
try {
    $result = $client->people->get('invalid_id');
} catch (ClozeAPIError $e) {
    // Access error details
    echo "Message: " . $e->getMessage() . "\n";
    echo "Error code: " . $e->getErrorcode() . "\n";
    $response = $e->getResponse();
}
```

## Advanced Usage

### Custom Request Parameters

```php
// Use API key as query parameter (instead of Bearer token)
$result = $client->makeRequest(
    'GET',
    '/v1/user/profile',
    [],
    null,
    true  // useApiKeyParam
);
```

### Handling Pagination

```php
// Using find() with pagination
$page = 1;
$pageSize = 50;
$allResults = [];

while (true) {
    $results = $client->people->find(
        ['segment' => 'lead'],
        $page,
        $pageSize
    );
    
    $allResults = array_merge($allResults, $results['list'] ?? []);
    
    if (count($results['list'] ?? []) < $pageSize) {
        break;
    }
    
    $page++;
}

// Using feed() with cursor-based pagination
$cursor = null;
$allItems = [];

while (true) {
    $feed = $client->people->feed($cursor);
    $allItems = array_merge($allItems, $feed['list'] ?? []);
    
    $cursor = $feed['cursor'] ?? null;
    if (!$cursor) {
        break;
    }
}
```

### Batch Operations

```php
// Create multiple people
$peopleData = [
    ['email' => 'person1@example.com', 'first' => 'Person', 'last' => 'One'],
    ['email' => 'person2@example.com', 'first' => 'Person', 'last' => 'Two'],
    ['email' => 'person3@example.com', 'first' => 'Person', 'last' => 'Three']
];

$created = [];
foreach ($peopleData as $personData) {
    try {
        $result = $client->people->create($personData);
        $created[] = $result;
    } catch (ClozeAPIError $e) {
        echo "Failed to create {$personData['email']}: " . $e->getMessage() . "\n";
    }
}
```

## Testing

See [`../php/TESTING.md`](../php/TESTING.md) for comprehensive testing documentation.

### Running Tests

```bash
# Unit tests
vendor/bin/phpunit --testsuite Unit

# Integration tests (requires CLOZE_API_KEY)
vendor/bin/phpunit --testsuite Integration

# E2E tests (requires CLOZE_API_KEY)
vendor/bin/phpunit --testsuite E2E
```

## Best Practices

1. **Use Environment Variables for API Keys**
   ```php
   $client = new ClozeClient(getenv('CLOZE_API_KEY'));
   ```

2. **Handle Rate Limits Gracefully**
   ```php
   try {
       $result = $client->account->getProfile();
   } catch (ClozeRateLimitError $e) {
       sleep(60);  // Wait before retry
       $result = $client->account->getProfile();
   }
   ```

3. **Use Pagination for Large Datasets**
   - Use `find()` for query-based pagination
   - Use `feed()` for cursor-based bulk retrieval

4. **Validate Data Before Sending**
   ```php
   $personData = [
       'email' => 'john@example.com',
       'first' => 'John',
       'last' => 'Doe'
   ];
   // Validate email format, required fields, etc.
   $result = $client->people->create($personData);
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

