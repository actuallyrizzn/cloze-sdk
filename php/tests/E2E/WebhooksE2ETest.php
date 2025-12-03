<?php

namespace Cloze\SDK\Tests\E2E;

class WebhooksE2ETest extends E2ETestCase
{
    private static ?string $subscriptionId = null;

    public function testSubscribeWebhook(): void
    {
        $targetUrl = 'https://example.com/webhook/' . time();
        $result = $this->client->webhooks->subscribe('person.change', $targetUrl);
        
        $this->assertEquals(0, $result['errorcode']);
        
        if (isset($result['uniqueid'])) {
            self::$subscriptionId = $result['uniqueid'];
        }
    }

    public function testListWebhooks(): void
    {
        $result = $this->client->webhooks->list();
        $this->assertEquals(0, $result['errorcode']);
        $this->assertArrayHasKey('list', $result);
    }

    public function testUnsubscribeWebhook(): void
    {
        if (!self::$subscriptionId) {
            $this->markTestSkipped('No subscription ID from previous test');
        }
        
        $result = $this->client->webhooks->unsubscribe('person.change', self::$subscriptionId);
        $this->assertEquals(0, $result['errorcode']);
        
        self::$subscriptionId = null;
    }
}

