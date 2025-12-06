<?php

namespace Cloze\SDK\Tests\Unit;

use PHPUnit\Framework\TestCase as BaseTestCase;
use Cloze\SDK\ClozeClient;
use PHPUnit\Framework\MockObject\MockObject;

/**
 * Base test case for unit tests.
 */
abstract class TestCase extends BaseTestCase
{
    /**
     * Create a mock ClozeClient.
     *
     * @param array $methods Methods to mock
     * @return MockObject|ClozeClient
     */
    protected function createMockClient(array $methods = []): MockObject
    {
        // Create a partial mock that mocks specified methods
        // Always include makeRequest unless it's already in the methods array
        $methodsToMock = in_array('makeRequest', $methods) ? $methods : array_merge(['makeRequest'], $methods);
        $methodsToMock = array_unique($methodsToMock);
        $client = $this->createPartialMock(ClozeClient::class, $methodsToMock);
        
        // Call the constructor with test API key to initialize endpoint modules
        $client->__construct('test_api_key');
        
        // Set up default makeRequest return value
        if (in_array('makeRequest', $methodsToMock)) {
            $client->method('makeRequest')->willReturn(['errorcode' => 0, 'data' => []]);
        }
        
        return $client;
    }

    /**
     * Create a real ClozeClient instance (for testing initialization).
     *
     * @param string|null $apiKey
     * @param string|null $oauthToken
     * @return ClozeClient
     */
    protected function createClient(?string $apiKey = 'test_key', ?string $oauthToken = null): ClozeClient
    {
        return new ClozeClient($apiKey, $oauthToken);
    }
}

