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
        $client = $this->createPartialMock(ClozeClient::class, $methods);
        $client->method('makeRequest')->willReturn(['errorcode' => 0, 'data' => []]);
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

