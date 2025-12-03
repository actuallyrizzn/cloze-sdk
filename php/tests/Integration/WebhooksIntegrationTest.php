<?php

namespace Cloze\SDK\Tests\Integration;

class WebhooksIntegrationTest extends IntegrationTestCase
{
    public function testList(): void
    {
        $result = $this->client->webhooks->list();
        $this->assertArrayHasKey('errorcode', $result);
    }
}

