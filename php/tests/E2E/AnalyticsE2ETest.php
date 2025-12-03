<?php

namespace Cloze\SDK\Tests\E2E;

class AnalyticsE2ETest extends E2ETestCase
{
    public function testQueryActivityWorkflow(): void
    {
        $queries = [
            'sentmails' => [
                'period_scale' => 'month',
                'periods' => 1
            ],
            'meetings' => [
                'period_scale' => 'week',
                'periods' => 2
            ]
        ];
        
        $result = $this->client->analytics->queryActivity($queries);
        $this->assertEquals(0, $result['errorcode']);
        $this->assertArrayHasKey('results', $result);
    }

    public function testQueryFunnelWorkflow(): void
    {
        $queries = [
            'test_funnel' => [
                'period_scale' => 'month',
                'periods' => 1
            ]
        ];
        
        $result = $this->client->analytics->queryFunnel($queries);
        $this->assertEquals(0, $result['errorcode']);
    }
}

