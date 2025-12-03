<?php

namespace Cloze\SDK\Tests\Integration;

class AnalyticsIntegrationTest extends IntegrationTestCase
{
    public function testQueryActivity(): void
    {
        $queries = [
            'sentmails' => [
                'period_scale' => 'month',
                'periods' => 1
            ]
        ];
        
        $result = $this->client->analytics->queryActivity($queries);
        $this->assertArrayHasKey('errorcode', $result);
    }

    public function testQueryFunnel(): void
    {
        $queries = [
            'test' => [
                'period_scale' => 'month',
                'periods' => 1
            ]
        ];
        
        $result = $this->client->analytics->queryFunnel($queries);
        $this->assertArrayHasKey('errorcode', $result);
    }

    public function testQueryLeads(): void
    {
        $queries = [
            'test' => [
                'period_scale' => 'month',
                'periods' => 1
            ]
        ];
        
        $result = $this->client->analytics->queryLeads($queries);
        $this->assertArrayHasKey('errorcode', $result);
    }

    public function testQueryProjects(): void
    {
        $queries = [
            'test' => [
                'period_scale' => 'month',
                'periods' => 1
            ]
        ];
        
        $result = $this->client->analytics->queryProjects($queries);
        $this->assertArrayHasKey('errorcode', $result);
    }

    public function testQueryTeamActivity(): void
    {
        $queries = [
            'test' => [
                'period_scale' => 'month',
                'periods' => 1
            ]
        ];
        
        $result = $this->client->analytics->queryTeamActivity($queries);
        $this->assertArrayHasKey('errorcode', $result);
    }

    public function testGetTeamActivityUpdate(): void
    {
        $result = $this->client->analytics->getTeamActivityUpdate();
        $this->assertArrayHasKey('errorcode', $result);
    }
}

