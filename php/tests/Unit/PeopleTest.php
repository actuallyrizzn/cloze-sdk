<?php

namespace Cloze\SDK\Tests\Unit;

use Cloze\SDK\ClozeClient;

class PeopleTest extends TestCase
{
    private function getPeople($client)
    {
        return $client->people;
    }

    public function testCreate(): void
    {
        $client = $this->createMockClient(['makeRequest']);
        $person = ['email' => 'test@example.com', 'first' => 'Test'];
        $client->expects($this->once())
            ->method('makeRequest')
            ->with('POST', '/v1/people/create', null, $person)
            ->willReturn(['errorcode' => 0]);
        
        $this->getPeople($client)->create($person);
    }

    public function testUpdate(): void
    {
        $client = $this->createMockClient(['makeRequest']);
        $person = ['email' => 'test@example.com'];
        $client->expects($this->once())
            ->method('makeRequest')
            ->with('POST', '/v1/people/update', null, $person)
            ->willReturn(['errorcode' => 0]);
        
        $this->getPeople($client)->update($person);
    }

    public function testGet(): void
    {
        $client = $this->createMockClient(['makeRequest']);
        $client->expects($this->once())
            ->method('makeRequest')
            ->with('GET', '/v1/people/get', ['identifier' => 'test@example.com'])
            ->willReturn(['errorcode' => 0, 'person' => []]);
        
        $this->getPeople($client)->get('test@example.com');
    }

    public function testGetWithIdentifierType(): void
    {
        $client = $this->createMockClient(['makeRequest']);
        $client->expects($this->once())
            ->method('makeRequest')
            ->with('GET', '/v1/people/get', ['identifier' => 'test@example.com', 'identifier_type' => 'email'])
            ->willReturn(['errorcode' => 0, 'person' => []]);
        
        $this->getPeople($client)->get('test@example.com', 'email');
    }

    public function testDelete(): void
    {
        $client = $this->createMockClient(['makeRequest']);
        $client->expects($this->once())
            ->method('makeRequest')
            ->with('DELETE', '/v1/people/delete', ['identifier' => 'test@example.com'])
            ->willReturn(['errorcode' => 0]);
        
        $this->getPeople($client)->delete('test@example.com');
    }

    public function testDeleteWithIdentifierType(): void
    {
        $client = $this->createMockClient(['makeRequest']);
        $client->expects($this->once())
            ->method('makeRequest')
            ->with('DELETE', '/v1/people/delete', ['identifier' => 'test@example.com', 'identifier_type' => 'email'])
            ->willReturn(['errorcode' => 0]);
        
        $this->getPeople($client)->delete('test@example.com', 'email');
    }

    public function testFind(): void
    {
        $client = $this->createMockClient(['makeRequest']);
        $client->expects($this->once())
            ->method('makeRequest')
            ->with('GET', '/v1/people/find', [])
            ->willReturn(['errorcode' => 0, 'list' => []]);
        
        $this->getPeople($client)->find();
    }

    public function testFindWithParams(): void
    {
        $client = $this->createMockClient(['makeRequest']);
        $client->expects($this->once())
            ->method('makeRequest')
            ->with(
                'GET',
                '/v1/people/find',
                $this->callback(function ($params) {
                    return isset($params['pagenumber']) && isset($params['pagesize']);
                })
            )
            ->willReturn(['errorcode' => 0, 'list' => []]);
        
        $this->getPeople($client)->find(['segment' => 'test'], 1, 10, false);
    }

    public function testFindWithAdditionalParams(): void
    {
        $client = $this->createMockClient(['makeRequest']);
        $client->expects($this->once())
            ->method('makeRequest')
            ->with(
                'GET',
                '/v1/people/find',
                $this->callback(function ($params) {
                    return isset($params['sort']) && isset($params['group']);
                })
            )
            ->willReturn(['errorcode' => 0, 'list' => []]);
        
        $this->getPeople($client)->find(null, null, null, null, ['sort' => 'name', 'group' => 'segment']);
    }

    public function testFeed(): void
    {
        $client = $this->createMockClient(['makeRequest']);
        $client->expects($this->once())
            ->method('makeRequest')
            ->with('GET', '/v1/people/feed', [])
            ->willReturn(['errorcode' => 0, 'list' => []]);
        
        $this->getPeople($client)->feed();
    }

    public function testFeedWithParams(): void
    {
        $client = $this->createMockClient(['makeRequest']);
        $client->expects($this->once())
            ->method('makeRequest')
            ->with(
                'GET',
                '/v1/people/feed',
                $this->callback(function ($params) {
                    return isset($params['cursor']) && isset($params['segment']);
                })
            )
            ->willReturn(['errorcode' => 0, 'list' => []]);
        
        $this->getPeople($client)->feed('cursor', 'segment', 'stage', 'local');
    }

    public function testFeedWithAdditionalParams(): void
    {
        $client = $this->createMockClient(['makeRequest']);
        $client->expects($this->once())
            ->method('makeRequest')
            ->with(
                'GET',
                '/v1/people/feed',
                $this->callback(function ($params) {
                    return isset($params['returnauditchanges']);
                })
            )
            ->willReturn(['errorcode' => 0, 'list' => []]);
        
        $this->getPeople($client)->feed(null, null, null, null, ['returnauditchanges' => true]);
    }
}

