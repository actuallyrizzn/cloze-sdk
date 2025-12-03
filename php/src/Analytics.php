<?php

namespace Cloze\SDK;

/**
 * Analytics endpoints.
 */
class Analytics
{
    private $client;

    public function __construct(ClozeClient $client)
    {
        $this->client = $client;
    }

    /**
     * Query user activity.
     *
     * @param array $queries Map of Query definitions
     * @return array Activity data for individual reporting periods
     */
    public function queryActivity(array $queries): array
    {
        return $this->client->makeRequest(
            'POST',
            '/v1/analytics/activity',
            null,
            ['queries' => $queries]
        );
    }

    /**
     * Query funnel information (BETA).
     *
     * @param array $queries Map of FunnelQuery definitions
     * @return array Funnel data
     */
    public function queryFunnel(array $queries): array
    {
        return $this->client->makeRequest(
            'POST',
            '/v1/analytics/funnel',
            null,
            ['queries' => $queries]
        );
    }

    /**
     * Query lead analytics.
     *
     * @param array $queries Map of Query definitions for leads
     * @return array Lead analytics data
     */
    public function queryLeads(array $queries): array
    {
        return $this->client->makeRequest(
            'POST',
            '/v1/analytics/leads',
            null,
            ['queries' => $queries]
        );
    }

    /**
     * Query project analytics.
     *
     * @param array $queries Map of ProjectQuery definitions
     * @return array Project analytics data
     */
    public function queryProjects(array $queries): array
    {
        return $this->client->makeRequest(
            'POST',
            '/v1/analytics/projects',
            null,
            ['queries' => $queries]
        );
    }

    /**
     * Query team activity.
     *
     * @param array $queries Map of Query definitions for team activity
     * @return array Team activity data
     */
    public function queryTeamActivity(array $queries): array
    {
        return $this->client->makeRequest(
            'POST',
            '/v1/analytics/teamactivity',
            null,
            ['queries' => $queries]
        );
    }

    /**
     * Get team activity update status.
     *
     * @return array Team activity update information
     */
    public function getTeamActivityUpdate(): array
    {
        return $this->client->makeRequest('GET', '/v1/analytics/teamactivity/update');
    }
}

