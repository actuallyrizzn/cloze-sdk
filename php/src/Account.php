<?php

namespace Cloze\SDK;

/**
 * Account endpoints.
 */
class Account
{
    private $client;

    public function __construct(ClozeClient $client)
    {
        $this->client = $client;
    }

    /**
     * Get custom fields.
     *
     * @param string|null $relationtype Optional filter - 'person', 'project', or 'company' (or null for all)
     * @return array List of custom fields
     */
    public function getFields(?string $relationtype = null): array
    {
        $params = [];
        if ($relationtype) {
            $params['relationtype'] = $relationtype;
        }

        return $this->client->makeRequest('GET', '/v1/user/fields', $params);
    }

    /**
     * Get user profile.
     *
     * @return array User profile information
     */
    public function getProfile(): array
    {
        return $this->client->makeRequest('GET', '/v1/user/profile');
    }

    /**
     * Get people contact segments.
     *
     * @return array List of people segments
     */
    public function getSegmentsPeople(): array
    {
        return $this->client->makeRequest('GET', '/v1/user/segments/people');
    }

    /**
     * Get project segments.
     *
     * @return array List of project segments
     */
    public function getSegmentsProjects(): array
    {
        return $this->client->makeRequest('GET', '/v1/user/segments/projects');
    }

    /**
     * Get people contact stages.
     *
     * @return array List of people stages
     */
    public function getStagesPeople(): array
    {
        return $this->client->makeRequest('GET', '/v1/user/stages/people');
    }

    /**
     * Get project stages.
     *
     * @return array List of project stages
     */
    public function getStagesProjects(): array
    {
        return $this->client->makeRequest('GET', '/v1/user/stages/projects');
    }

    /**
     * Get steps.
     *
     * @return array List of steps
     */
    public function getSteps(): array
    {
        return $this->client->makeRequest('GET', '/v1/user/steps');
    }

    /**
     * Get views and audiences.
     *
     * @return array List of views and audiences
     */
    public function getViews(): array
    {
        return $this->client->makeRequest('GET', '/v1/user/views');
    }
}

