<?php

namespace Cloze\SDK\Tests\Integration;

use PHPUnit\Framework\TestCase;
use Cloze\SDK\ClozeClient;

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
}

