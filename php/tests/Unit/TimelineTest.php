<?php

namespace Cloze\SDK\Tests\Unit;

use Cloze\SDK\ClozeClient;

class TimelineTest extends TestCase
{
    private function getTimeline($client)
    {
        return $client->timeline;
    }

    public function testCreateCommunication(): void
    {
        $client = $this->createMockClient(['makeRequest']);
        $communication = ['type' => 'email', 'subject' => 'Test'];
        $client->expects($this->once())
            ->method('makeRequest')
            ->with('POST', '/v1/timeline/communication/create', null, $communication)
            ->willReturn(['errorcode' => 0]);
        
        $this->getTimeline($client)->createCommunication($communication);
    }

    public function testCreateContent(): void
    {
        $client = $this->createMockClient(['makeRequest']);
        $content = ['type' => 'note', 'text' => 'Test note'];
        $client->expects($this->once())
            ->method('makeRequest')
            ->with('POST', '/v1/timeline/content/create', null, $content)
            ->willReturn(['errorcode' => 0]);
        
        $this->getTimeline($client)->createContent($content);
    }

    public function testCreateTodo(): void
    {
        $client = $this->createMockClient(['makeRequest']);
        $todo = ['text' => 'Test todo', 'due' => 1234567890];
        $client->expects($this->once())
            ->method('makeRequest')
            ->with('POST', '/v1/timeline/todo/create', null, $todo)
            ->willReturn(['errorcode' => 0]);
        
        $this->getTimeline($client)->createTodo($todo);
    }

    public function testGetMessageOpens(): void
    {
        $client = $this->createMockClient(['makeRequest']);
        $client->expects($this->once())
            ->method('makeRequest')
            ->with('GET', '/v1/messages/opens', [])
            ->willReturn(['errorcode' => 0, 'list' => []]);
        
        $this->getTimeline($client)->getMessageOpens();
    }

    public function testGetMessageOpensWithParams(): void
    {
        $client = $this->createMockClient(['makeRequest']);
        $client->expects($this->once())
            ->method('makeRequest')
            ->with(
                'GET',
                '/v1/messages/opens',
                $this->callback(function ($params) {
                    return isset($params['from']) && isset($params['user']);
                })
            )
            ->willReturn(['errorcode' => 0, 'list' => []]);
        
        $this->getTimeline($client)->getMessageOpens(1234567890, 'test@example.com');
    }
}

