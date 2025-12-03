<?php

namespace Cloze\SDK\Tests\Unit;

use Cloze\SDK\ClozeClient;
use Cloze\SDK\Exceptions\ClozeAPIError;
use Cloze\SDK\Exceptions\ClozeAuthenticationError;
use Cloze\SDK\Exceptions\ClozeRateLimitError;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\MockObject\MockObject;

class ClientTest extends TestCase
{
    public function testInitWithApiKey(): void
    {
        $client = $this->createClient('test_key');
        // Verify client was created successfully (no exception thrown)
        $this->assertInstanceOf(ClozeClient::class, $client);
    }

    public function testInitWithOAuthToken(): void
    {
        $client = $this->createClient(null, 'test_token');
        // Verify client was created successfully (no exception thrown)
        $this->assertInstanceOf(ClozeClient::class, $client);
    }

    public function testInitWithCustomBaseUrl(): void
    {
        $client = new ClozeClient('test_key', null, 'https://custom.api.com');
        // Verify client was created successfully
        $this->assertInstanceOf(ClozeClient::class, $client);
    }

    public function testInitWithCustomTimeout(): void
    {
        $client = new ClozeClient('test_key', null, null, 60);
        // Verify client was created successfully
        $this->assertInstanceOf(ClozeClient::class, $client);
    }

    public function testInitWithoutAuthThrowsException(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Either apiKey or oauthToken must be provided');
        new ClozeClient();
    }

    public function testEndpointModulesInitialized(): void
    {
        $client = $this->createClient();
        $this->assertNotNull($client->analytics);
        $this->assertNotNull($client->team);
        $this->assertNotNull($client->account);
        $this->assertNotNull($client->projects);
        $this->assertNotNull($client->people);
        $this->assertNotNull($client->companies);
        $this->assertNotNull($client->timeline);
        $this->assertNotNull($client->webhooks);
    }

    public function testMakeRequestSuccess(): void
    {
        $client = $this->createClient();
        
        // Mock the Guzzle client
        $mockGuzzle = $this->createMock(\GuzzleHttp\Client::class);
        $response = new Response(200, [], json_encode(['errorcode' => 0, 'data' => 'test']));
        $mockGuzzle->method('request')->willReturn($response);
        
        // Use reflection to set the private client property
        $reflection = new \ReflectionClass($client);
        $property = $reflection->getProperty('client');
        $property->setAccessible(true);
        $property->setValue($client, $mockGuzzle);
        
        $result = $client->makeRequest('GET', '/v1/user/profile');
        $this->assertEquals(['errorcode' => 0, 'data' => 'test'], $result);
    }

    public function testMakeRequestWithParams(): void
    {
        $client = $this->createClient();
        
        $mockGuzzle = $this->createMock(\GuzzleHttp\Client::class);
        $response = new Response(200, [], json_encode(['errorcode' => 0]));
        $mockGuzzle->expects($this->once())
            ->method('request')
            ->with(
                $this->equalTo('GET'),
                $this->equalTo('/v1/user/profile'),
                $this->callback(function ($options) {
                    return isset($options['query']['key']) && $options['query']['key'] === 'value';
                })
            )
            ->willReturn($response);
        
        $reflection = new \ReflectionClass($client);
        $property = $reflection->getProperty('client');
        $property->setAccessible(true);
        $property->setValue($client, $mockGuzzle);
        
        $client->makeRequest('GET', '/v1/user/profile', ['key' => 'value']);
    }

    public function testMakeRequestWithJsonData(): void
    {
        $client = $this->createClient();
        
        $mockGuzzle = $this->createMock(\GuzzleHttp\Client::class);
        $response = new Response(200, [], json_encode(['errorcode' => 0]));
        $mockGuzzle->expects($this->once())
            ->method('request')
            ->with(
                $this->equalTo('POST'),
                $this->equalTo('/v1/people/create'),
                $this->callback(function ($options) {
                    return isset($options['json']['name']) && $options['json']['name'] === 'Test';
                })
            )
            ->willReturn($response);
        
        $reflection = new \ReflectionClass($client);
        $property = $reflection->getProperty('client');
        $property->setAccessible(true);
        $property->setValue($client, $mockGuzzle);
        
        $client->makeRequest('POST', '/v1/people/create', null, ['name' => 'Test']);
    }

    public function testMakeRequestWithApiKeyParam(): void
    {
        $client = $this->createClient('test_key');
        
        $mockGuzzle = $this->createMock(\GuzzleHttp\Client::class);
        $response = new Response(200, [], json_encode(['errorcode' => 0]));
        $mockGuzzle->expects($this->once())
            ->method('request')
            ->with(
                $this->anything(),
                $this->anything(),
                $this->callback(function ($options) {
                    return isset($options['query']['api_key']) && $options['query']['api_key'] === 'test_key';
                })
            )
            ->willReturn($response);
        
        $reflection = new \ReflectionClass($client);
        $property = $reflection->getProperty('client');
        $property->setAccessible(true);
        $property->setValue($client, $mockGuzzle);
        
        $client->makeRequest('GET', '/v1/user/profile', [], null, true);
    }

    public function testHandleResponseRateLimit(): void
    {
        $client = $this->createClient();
        $response = new Response(429);
        
        $reflection = new \ReflectionClass($client);
        $method = $reflection->getMethod('handleResponse');
        $method->setAccessible(true);
        
        $this->expectException(ClozeRateLimitError::class);
        $method->invoke($client, $response);
    }

    public function testHandleResponseAuthenticationError(): void
    {
        $client = $this->createClient();
        $response = new Response(401);
        
        $reflection = new \ReflectionClass($client);
        $method = $reflection->getMethod('handleResponse');
        $method->setAccessible(true);
        
        $this->expectException(ClozeAuthenticationError::class);
        $method->invoke($client, $response);
    }

    public function testHandleResponseWithErrorcode(): void
    {
        $client = $this->createClient();
        $response = new Response(200, [], json_encode(['errorcode' => 1, 'message' => 'Error occurred']));
        
        $reflection = new \ReflectionClass($client);
        $method = $reflection->getMethod('handleResponse');
        $method->setAccessible(true);
        
        $this->expectException(ClozeAPIError::class);
        $this->expectExceptionMessage('API error: Error occurred');
        $method->invoke($client, $response);
    }

    public function testHandleResponseInvalidJson(): void
    {
        $client = $this->createClient();
        $response = new Response(200, [], 'invalid json');
        
        $reflection = new \ReflectionClass($client);
        $method = $reflection->getMethod('handleResponse');
        $method->setAccessible(true);
        
        $this->expectException(ClozeAPIError::class);
        $this->expectExceptionMessage('Invalid response format');
        $method->invoke($client, $response);
    }

    public function testHandleResponseSuccess(): void
    {
        $client = $this->createClient();
        $response = new Response(200, [], json_encode(['errorcode' => 0, 'data' => 'success']));
        
        $reflection = new \ReflectionClass($client);
        $method = $reflection->getMethod('handleResponse');
        $method->setAccessible(true);
        
        $result = $method->invoke($client, $response);
        $this->assertEquals(['errorcode' => 0, 'data' => 'success'], $result);
    }

    public function testMakeRequestHandlesRequestException(): void
    {
        $client = $this->createClient();
        
        $mockGuzzle = $this->createMock(\GuzzleHttp\Client::class);
        $mockGuzzle->method('request')
            ->willThrowException(new RequestException('Connection error', new \GuzzleHttp\Psr7\Request('GET', 'test')));
        
        $reflection = new \ReflectionClass($client);
        $property = $reflection->getProperty('client');
        $property->setAccessible(true);
        $property->setValue($client, $mockGuzzle);
        
        $this->expectException(ClozeAPIError::class);
        $this->expectExceptionMessage('Request failed');
        $client->makeRequest('GET', '/v1/user/profile');
    }
}

