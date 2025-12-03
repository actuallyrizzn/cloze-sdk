<?php

namespace Cloze\SDK\Tests\Unit;

use Cloze\SDK\ClozeClient;
use Cloze\SDK\Exceptions\ClozeValidationError;

class WebhooksTest extends TestCase
{
    private function getWebhooks($client)
    {
        return $client->webhooks;
    }

    public function testList(): void
    {
        $client = $this->createMockClient(['makeRequest']);
        $client->expects($this->once())
            ->method('makeRequest')
            ->with('GET', '/v1/webhooks')
            ->willReturn(['errorcode' => 0, 'list' => []]);
        
        $this->getWebhooks($client)->list();
    }

    public function testSubscribe(): void
    {
        $client = $this->createMockClient(['makeRequest']);
        $client->expects($this->once())
            ->method('makeRequest')
            ->with(
                'POST',
                '/v1/webhooks/subscribe',
                null,
                $this->callback(function ($data) {
                    return isset($data['event']) && isset($data['target_url']);
                })
            )
            ->willReturn(['errorcode' => 0, 'uniqueid' => 'test_id']);
        
        $this->getWebhooks($client)->subscribe('person.change', 'https://example.com/webhook');
    }

    public function testSubscribeWithAllParams(): void
    {
        $client = $this->createMockClient(['makeRequest']);
        $filters = [['person' => ['segment' => 'test']]];
        $client->expects($this->once())
            ->method('makeRequest')
            ->with(
                'POST',
                '/v1/webhooks/subscribe',
                null,
                $this->callback(function ($data) use ($filters) {
                    return isset($data['scope']) &&
                           isset($data['filters']) &&
                           isset($data['client_type']) &&
                           isset($data['client_reference']) &&
                           isset($data['ttl']);
                })
            )
            ->willReturn(['errorcode' => 0, 'uniqueid' => 'test_id']);
        
        $this->getWebhooks($client)->subscribe(
            'person.audit.change',
            'https://example.com/webhook',
            'local',
            $filters,
            'human',
            'test_ref',
            3600
        );
    }

    public function testUnsubscribeWithUniqueid(): void
    {
        $client = $this->createMockClient(['makeRequest']);
        $client->expects($this->once())
            ->method('makeRequest')
            ->with(
                'POST',
                '/v1/webhooks/unsubscribe',
                null,
                $this->callback(function ($data) {
                    return isset($data['event']) && isset($data['uniqueid']);
                })
            )
            ->willReturn(['errorcode' => 0]);
        
        $this->getWebhooks($client)->unsubscribe('person.audit.change', 'test_id');
    }

    public function testUnsubscribeWithClientReference(): void
    {
        $client = $this->createMockClient(['makeRequest']);
        $client->expects($this->once())
            ->method('makeRequest')
            ->with(
                'POST',
                '/v1/webhooks/unsubscribe',
                null,
                $this->callback(function ($data) {
                    return isset($data['event']) && isset($data['client_reference']);
                })
            )
            ->willReturn(['errorcode' => 0]);
        
        $this->getWebhooks($client)->unsubscribe('person.audit.change', null, 'test_ref');
    }

    public function testUnsubscribeWithoutParamsThrowsException(): void
    {
        $client = $this->createClient();
        $this->expectException(ClozeValidationError::class);
        $this->expectExceptionMessage('Either uniqueid or clientReference must be provided');
        
        $this->getWebhooks($client)->unsubscribe('person.audit.change');
    }
}

