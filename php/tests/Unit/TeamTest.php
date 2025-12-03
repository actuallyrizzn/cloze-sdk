<?php

namespace Cloze\SDK\Tests\Unit;

use Cloze\SDK\ClozeClient;

class TeamTest extends TestCase
{
    private function getTeam($client)
    {
        return $client->team;
    }

    public function testListMembers(): void
    {
        $client = $this->createMockClient(['makeRequest']);
        $client->expects($this->once())
            ->method('makeRequest')
            ->with('GET', '/v1/team/members/list')
            ->willReturn(['errorcode' => 0, 'list' => []]);
        
        $result = $this->getTeam($client)->listMembers();
        $this->assertEquals(['errorcode' => 0, 'list' => []], $result);
    }

    public function testUpdateMembers(): void
    {
        $client = $this->createMockClient(['makeRequest']);
        $members = [['id' => '1', 'role' => 'admin']];
        $client->expects($this->once())
            ->method('makeRequest')
            ->with('POST', '/v1/team/members/update', null, ['members' => $members])
            ->willReturn(['errorcode' => 0]);
        
        $this->getTeam($client)->updateMembers($members);
    }

    public function testGetNodes(): void
    {
        $client = $this->createMockClient(['makeRequest']);
        $client->expects($this->once())
            ->method('makeRequest')
            ->with('GET', '/v1/team/nodes')
            ->willReturn(['errorcode' => 0, 'nodes' => []]);
        
        $this->getTeam($client)->getNodes();
    }

    public function testGetRoles(): void
    {
        $client = $this->createMockClient(['makeRequest']);
        $client->expects($this->once())
            ->method('makeRequest')
            ->with('GET', '/v1/team/roles')
            ->willReturn(['errorcode' => 0, 'list' => []]);
        
        $this->getTeam($client)->getRoles();
    }
}

