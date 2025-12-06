<?php

namespace Cloze\SDK\Tests\Integration;

use PHPUnit\Framework\TestCase;
use Cloze\SDK\ClozeClient;
use Cloze\SDK\Exceptions\ClozeAPIError;
use Cloze\SDK\Exceptions\ClozeRateLimitError;

/**
 * Base test case for integration tests.
 */
abstract class IntegrationTestCase extends TestCase
{
    protected ?ClozeClient $client = null;

    protected function setUp(): void
    {
        parent::setUp();
        
        $apiKey = getenv('CLOZE_API_KEY');
        if (!$apiKey) {
            $this->markTestSkipped('CLOZE_API_KEY environment variable is not set');
        }
        
        $this->client = new ClozeClient($apiKey);
    }

    protected function tearDown(): void
    {
        $this->client = null;
        parent::tearDown();
    }

    /**
     * Execute a callable with retry on rate limit errors.
     *
     * @param callable $func Function to execute
     * @param int $maxRetries Maximum number of retries
     * @return mixed
     */
    protected function makeRequestWithRetry(callable $func, int $maxRetries = 3)
    {
        for ($attempt = 0; $attempt < $maxRetries; $attempt++) {
            try {
                return $func();
            } catch (ClozeRateLimitError $e) {
                if ($attempt < $maxRetries - 1) {
                    sleep(pow(2, $attempt)); // Exponential backoff
                    continue;
                }
                $this->markTestSkipped('Rate limit exceeded');
                return null; // Never reached, but satisfies return type
            }
        }
        return null; // Never reached, but satisfies return type
    }
}

