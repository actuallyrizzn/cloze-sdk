# Cloze PHP SDK

PHP SDK for the Cloze API with 100% endpoint coverage.

## Installation

### Using Composer

```bash
composer require cloze/cloze-sdk-php
```

### Manual Installation

```bash
git clone https://github.com/cloze/cloze-sdk-php
cd cloze-sdk-php
composer install
```

## Quick Start

```php
<?php

require 'vendor/autoload.php';

use Cloze\SDK\ClozeClient;

// Initialize client with API key
$client = new ClozeClient('your_api_key_here');

// Or with OAuth token
$client = new ClozeClient(null, 'your_oauth_token_here');

// Get user profile
$profile = $client->account->getProfile();
print_r($profile);

// Query analytics
$activity = $client->analytics->queryActivity([
    'my_query' => [
        'max' => 30,
        'scale' => 'month',
        'measures' => ['sentmails', 'meetings']
    ]
]);

// Create a person
$person = $client->people->create([
    'email' => 'john@example.com',
    'first' => 'John',
    'last' => 'Doe'
]);

// Subscribe to webhooks
$subscription = $client->webhooks->subscribe(
    'person.audit.change',
    'https://your-app.com/webhook',
    'local'
);
```

## API Coverage

This SDK provides 100% coverage of all Cloze API endpoints:

### Analytics (6 endpoints)
- `queryActivity()` - Query user activity
- `queryFunnel()` - Query funnel information
- `queryLeads()` - Query lead analytics
- `queryProjects()` - Query project analytics
- `queryTeamActivity()` - Query team activity
- `getTeamActivityUpdate()` - Get team activity update status

### Team (4 endpoints)
- `listMembers()` - List team members
- `updateMembers()` - Update team members
- `getNodes()` - Get team organizational nodes
- `getRoles()` - Get team roles

### Account (7 endpoints)
- `getFields()` - Get custom fields
- `getProfile()` - Get user profile
- `getSegmentsPeople()` - Get people contact segments
- `getSegmentsProjects()` - Get project segments
- `getStagesPeople()` - Get people contact stages
- `getStagesProjects()` - Get project stages
- `getSteps()` - Get steps
- `getViews()` - Get views and audiences

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
- `createCommunication()` - Create communication timeline item
- `createContent()` - Create content timeline item
- `createTodo()` - Create todo timeline item
- `getMessageOpens()` - Retrieve email opens

### Webhooks (3 endpoints)
- `list()` - List webhook subscriptions
- `subscribe()` - Subscribe to change events
- `unsubscribe()` - Cancel a subscription

## Authentication

The SDK supports three authentication methods:

1. **API Key** (simplest for development)
   ```php
   $client = new ClozeClient('your_api_key');
   ```

2. **OAuth 2.0** (required for public integrations)
   ```php
   $client = new ClozeClient(null, 'your_oauth_token');
   ```

3. **Bearer Token** (alternative API key format)
   ```php
   $client = new ClozeClient('your_api_key'); // Uses bearer token format
   ```

## Error Handling

The SDK provides custom exceptions:

```php
use Cloze\SDK\Exceptions\ClozeAPIError;
use Cloze\SDK\Exceptions\ClozeAuthenticationError;
use Cloze\SDK\Exceptions\ClozeRateLimitError;

try {
    $result = $client->account->getProfile();
} catch (ClozeAuthenticationError $e) {
    echo "Authentication failed\n";
} catch (ClozeRateLimitError $e) {
    echo "Rate limit exceeded\n";
} catch (ClozeAPIError $e) {
    echo "API error: " . $e->getMessage() . "\n";
}
```

## Requirements

- PHP 7.4 or higher
- Guzzle HTTP Client 7.0 or higher

## Documentation

Full API documentation is available at: https://developer.cloze.com/

## License

MIT License

## Support

For issues and questions:
- GitHub Issues: https://github.com/cloze/cloze-sdk-php/issues
- Email: support@cloze.com

