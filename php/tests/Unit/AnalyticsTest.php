<?php

namespace Cloze\SDK\Tests\Unit;

use Cloze\SDK\ClozeClient;

class AnalyticsTest extends TestCase
{
    private function getAnalytics($client)
    {
        return $client->analytics;
    }

    public function testQueryActivity(): void
    {
        $client = $this->createMockClient(['makeRequest']);
        $client->expects($this->once())
            ->method('makeRequest')
            ->with(
                $this->equalTo('POST'),
                $this->equalTo('/v1/analytics/activity'),
                $this->isNull(),
                $this->equalTo(['queries' => ['test' => []]])
            )
            ->willReturn(['errorcode' => 0, 'data' => []]);
        
        $result = $this->getAnalytics($client)->queryActivity(['test' => []]);
        $this->assertEquals(['errorcode' => 0, 'data' => []], $result);
    }

    public function testQueryFunnel(): void
    {
        $client = $this->createMockClient(['makeRequest']);
        $client->expects($this->once())
            ->method('makeRequest')
            ->with('POST', '/v1/analytics/funnel', null, ['queries' => []])
            ->willReturn(['errorcode' => 0]);
        
        $this->getAnalytics($client)->queryFunnel([]);
    }

    public function testQueryLeads(): void
    {
        $client = $this->createMockClient(['makeRequest']);
        $client->expects($this->once())
            ->method('makeRequest')
            ->with('POST', '/v1/analytics/leads', null, ['queries' => []])
            ->willReturn(['errorcode' => 0]);
        
        $this->getAnalytics($client)->queryLeads([]);
    }

    public function testQueryProjects(): void
    {
        $client = $this->createMockClient(['makeRequest']);
        $client->expects($this->once())
            ->method('makeRequest')
            ->with('POST', '/v1/analytics/projects', null, ['queries' => []])
            ->willReturn(['errorcode' => 0]);
        
        $this->getAnalytics($client)->queryProjects([]);
    }

    public function testQueryTeamActivity(): void
    {
        $client = $this->createMockClient(['makeRequest']);
        $client->expects($this->once())
            ->method('makeRequest')
            ->with('POST', '/v1/analytics/teamactivity', null, ['queries' => []])
            ->willReturn(['errorcode' => 0]);
        
        $this->getAnalytics($client)->queryTeamActivity([]);
    }

    public function testGetTeamActivityUpdate(): void
    {
        $client = $this->createMockClient(['makeRequest']);
        $client->expects($this->once())
            ->method('makeRequest')
            ->with('GET', '/v1/analytics/teamactivity/update')
            ->willReturn(['errorcode' => 0]);
        
        $this->getAnalytics($client)->getTeamActivityUpdate();
    }
}

