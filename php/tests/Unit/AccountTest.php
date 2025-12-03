<?php

namespace Cloze\SDK\Tests\Unit;

use Cloze\SDK\ClozeClient;

class AccountTest extends TestCase
{
    private function getAccount($client)
    {
        return $client->account;
    }

    public function testGetFields(): void
    {
        $client = $this->createMockClient(['makeRequest']);
        $client->expects($this->once())
            ->method('makeRequest')
            ->with('GET', '/v1/user/fields', [])
            ->willReturn(['errorcode' => 0, 'list' => []]);
        
        $this->getAccount($client)->getFields();
    }

    public function testGetFieldsWithRelationtype(): void
    {
        $client = $this->createMockClient(['makeRequest']);
        $client->expects($this->once())
            ->method('makeRequest')
            ->with('GET', '/v1/user/fields', ['relationtype' => 'person'])
            ->willReturn(['errorcode' => 0, 'list' => []]);
        
        $this->getAccount($client)->getFields('person');
    }

    public function testGetProfile(): void
    {
        $client = $this->createMockClient(['makeRequest']);
        $client->expects($this->once())
            ->method('makeRequest')
            ->with('GET', '/v1/user/profile')
            ->willReturn(['errorcode' => 0, 'user' => []]);
        
        $this->getAccount($client)->getProfile();
    }

    public function testGetSegmentsPeople(): void
    {
        $client = $this->createMockClient(['makeRequest']);
        $client->expects($this->once())
            ->method('makeRequest')
            ->with('GET', '/v1/user/segments/people')
            ->willReturn(['errorcode' => 0, 'list' => []]);
        
        $this->getAccount($client)->getSegmentsPeople();
    }

    public function testGetSegmentsProjects(): void
    {
        $client = $this->createMockClient(['makeRequest']);
        $client->expects($this->once())
            ->method('makeRequest')
            ->with('GET', '/v1/user/segments/projects')
            ->willReturn(['errorcode' => 0, 'list' => []]);
        
        $this->getAccount($client)->getSegmentsProjects();
    }

    public function testGetStagesPeople(): void
    {
        $client = $this->createMockClient(['makeRequest']);
        $client->expects($this->once())
            ->method('makeRequest')
            ->with('GET', '/v1/user/stages/people')
            ->willReturn(['errorcode' => 0, 'list' => []]);
        
        $this->getAccount($client)->getStagesPeople();
    }

    public function testGetStagesProjects(): void
    {
        $client = $this->createMockClient(['makeRequest']);
        $client->expects($this->once())
            ->method('makeRequest')
            ->with('GET', '/v1/user/stages/projects')
            ->willReturn(['errorcode' => 0, 'list' => []]);
        
        $this->getAccount($client)->getStagesProjects();
    }

    public function testGetSteps(): void
    {
        $client = $this->createMockClient(['makeRequest']);
        $client->expects($this->once())
            ->method('makeRequest')
            ->with('GET', '/v1/user/steps')
            ->willReturn(['errorcode' => 0, 'list' => []]);
        
        $this->getAccount($client)->getSteps();
    }

    public function testGetViews(): void
    {
        $client = $this->createMockClient(['makeRequest']);
        $client->expects($this->once())
            ->method('makeRequest')
            ->with('GET', '/v1/user/views')
            ->willReturn(['errorcode' => 0, 'list' => []]);
        
        $this->getAccount($client)->getViews();
    }
}

