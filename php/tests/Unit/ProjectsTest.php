<?php

namespace Cloze\SDK\Tests\Unit;

use Cloze\SDK\ClozeClient;

class ProjectsTest extends TestCase
{
    private function getProjects($client)
    {
        return $client->projects;
    }

    public function testCreate(): void
    {
        $client = $this->createMockClient(['makeRequest']);
        $project = ['name' => 'Test Project'];
        $client->expects($this->once())
            ->method('makeRequest')
            ->with('POST', '/v1/projects/create', null, $project)
            ->willReturn(['errorcode' => 0]);
        
        $this->getProjects($client)->create($project);
    }

    public function testUpdate(): void
    {
        $client = $this->createMockClient(['makeRequest']);
        $project = ['name' => 'Updated Project'];
        $client->expects($this->once())
            ->method('makeRequest')
            ->with('POST', '/v1/projects/update', null, $project)
            ->willReturn(['errorcode' => 0]);
        
        $this->getProjects($client)->update($project);
    }

    public function testGet(): void
    {
        $client = $this->createMockClient(['makeRequest']);
        $client->expects($this->once())
            ->method('makeRequest')
            ->with('GET', '/v1/projects/get', ['identifier' => 'test@example.com'])
            ->willReturn(['errorcode' => 0, 'project' => []]);
        
        $this->getProjects($client)->get('test@example.com');
    }

    public function testGetWithIdentifierType(): void
    {
        $client = $this->createMockClient(['makeRequest']);
        $client->expects($this->once())
            ->method('makeRequest')
            ->with('GET', '/v1/projects/get', ['identifier' => 'test@example.com', 'identifier_type' => 'email'])
            ->willReturn(['errorcode' => 0, 'project' => []]);
        
        $this->getProjects($client)->get('test@example.com', 'email');
    }

    public function testDelete(): void
    {
        $client = $this->createMockClient(['makeRequest']);
        $client->expects($this->once())
            ->method('makeRequest')
            ->with('DELETE', '/v1/projects/delete', ['identifier' => 'test@example.com'])
            ->willReturn(['errorcode' => 0]);
        
        $this->getProjects($client)->delete('test@example.com');
    }

    public function testDeleteWithIdentifierType(): void
    {
        $client = $this->createMockClient(['makeRequest']);
        $client->expects($this->once())
            ->method('makeRequest')
            ->with('DELETE', '/v1/projects/delete', ['identifier' => 'test@example.com', 'identifier_type' => 'email'])
            ->willReturn(['errorcode' => 0]);
        
        $this->getProjects($client)->delete('test@example.com', 'email');
    }

    public function testFind(): void
    {
        $client = $this->createMockClient(['makeRequest']);
        $client->expects($this->once())
            ->method('makeRequest')
            ->with('GET', '/v1/projects/find', [])
            ->willReturn(['errorcode' => 0, 'list' => []]);
        
        $this->getProjects($client)->find();
    }

    public function testFindWithParams(): void
    {
        $client = $this->createMockClient(['makeRequest']);
        $client->expects($this->once())
            ->method('makeRequest')
            ->with(
                'GET',
                '/v1/projects/find',
                $this->callback(function ($params) {
                    return isset($params['segment']) && 
                           isset($params['pagenumber']) && 
                           isset($params['pagesize']) && 
                           isset($params['countonly']);
                })
            )
            ->willReturn(['errorcode' => 0, 'list' => []]);
        
        $this->getProjects($client)->find(['segment' => 'test'], 1, 10, false);
    }

    public function testFeed(): void
    {
        $client = $this->createMockClient(['makeRequest']);
        $client->expects($this->once())
            ->method('makeRequest')
            ->with('GET', '/v1/projects/feed', [])
            ->willReturn(['errorcode' => 0, 'list' => []]);
        
        $this->getProjects($client)->feed();
    }

    public function testFeedWithParams(): void
    {
        $client = $this->createMockClient(['makeRequest']);
        $client->expects($this->once())
            ->method('makeRequest')
            ->with(
                'GET',
                '/v1/projects/feed',
                $this->callback(function ($params) {
                    return isset($params['cursor']) && 
                           isset($params['segment']) && 
                           isset($params['stage']) && 
                           isset($params['scope']);
                })
            )
            ->willReturn(['errorcode' => 0, 'list' => []]);
        
        $this->getProjects($client)->feed('test_cursor', 'test', 'active', 'local');
    }

    public function testFindWithAdditionalParams(): void
    {
        $client = $this->createMockClient(['makeRequest']);
        $client->expects($this->once())
            ->method('makeRequest')
            ->with(
                'GET',
                '/v1/projects/find',
                $this->callback(function ($params) {
                    return isset($params['sort']) && isset($params['group']);
                })
            )
            ->willReturn(['errorcode' => 0, 'list' => []]);
        
        $this->getProjects($client)->find(null, null, null, null, ['sort' => 'name', 'group' => 'segment']);
    }

    public function testFeedWithAdditionalParams(): void
    {
        $client = $this->createMockClient(['makeRequest']);
        $client->expects($this->once())
            ->method('makeRequest')
            ->with(
                'GET',
                '/v1/projects/feed',
                $this->callback(function ($params) {
                    return isset($params['returnauditchanges']);
                })
            )
            ->willReturn(['errorcode' => 0, 'list' => []]);
        
        $this->getProjects($client)->feed(null, null, null, null, ['returnauditchanges' => true]);
    }
}

