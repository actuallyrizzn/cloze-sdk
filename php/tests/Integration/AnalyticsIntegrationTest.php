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
        // API returns query results directly without errorcode wrapper
        $this->assertIsArray($result);
        $this->assertArrayHasKey('sentmails', $result);
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
        // API returns query results directly
        $this->assertIsArray($result);
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
        // API returns query results directly
        $this->assertIsArray($result);
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
        // API returns query results directly
        $this->assertIsArray($result);
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
        // API returns query results directly
        $this->assertIsArray($result);
    }

    public function testGetTeamActivityUpdate(): void
    {
        $result = $this->client->analytics->getTeamActivityUpdate();
        $this->assertArrayHasKey('errorcode', $result);
    }
}

