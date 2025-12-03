<?php

namespace Cloze\SDK;

/**
 * Projects endpoints.
 */
class Projects
{
    private $client;

    public function __construct(ClozeClient $client)
    {
        $this->client = $client;
    }

    /**
     * Create a new project or merge updates into an existing one.
     *
     * @param array $project Project data to create
     * @return array Creation result
     */
    public function create(array $project): array
    {
        return $this->client->makeRequest('POST', '/v1/projects/create', null, $project);
    }

    /**
     * Merge updates into an existing project.
     *
     * @param array $project Project data to update
     * @return array Update result
     */
    public function update(array $project): array
    {
        return $this->client->makeRequest('POST', '/v1/projects/update', null, $project);
    }

    /**
     * Get a project by identifier.
     *
     * @param string $identifier Unique identifier (email, twitter, direct ID, etc.)
     * @param string|null $identifierType Optional type of identifier
     * @return array Project data
     */
    public function get(string $identifier, ?string $identifierType = null): array
    {
        $params = ['identifier' => $identifier];
        if ($identifierType) {
            $params['identifier_type'] = $identifierType;
        }

        return $this->client->makeRequest('GET', '/v1/projects/get', $params);
    }

    /**
     * Delete a project.
     *
     * @param string $identifier Unique identifier
     * @param string|null $identifierType Optional type of identifier
     * @return array Deletion result
     */
    public function delete(string $identifier, ?string $identifierType = null): array
    {
        $params = ['identifier' => $identifier];
        if ($identifierType) {
            $params['identifier_type'] = $identifierType;
        }

        return $this->client->makeRequest('DELETE', '/v1/projects/delete', $params);
    }

    /**
     * Find projects with extensive query, sort and group by options.
     *
     * @param array|null $query Query parameters
     * @param int|null $pagenumber Page number for pagination
     * @param int|null $pagesize Page size for pagination
     * @param bool|null $countonly If true, return only count
     * @param array $additionalParams Additional query parameters
     * @return array List of matching projects or count
     */
    public function find(
        ?array $query = null,
        ?int $pagenumber = null,
        ?int $pagesize = null,
        ?bool $countonly = null,
        array $additionalParams = []
    ): array {
        $params = $additionalParams;
        if ($query) {
            $params = array_merge($params, $query);
        }
        if ($pagenumber !== null) {
            $params['pagenumber'] = $pagenumber;
        }
        if ($pagesize !== null) {
            $params['pagesize'] = $pagesize;
        }
        if ($countonly !== null) {
            $params['countonly'] = $countonly;
        }

        return $this->client->makeRequest('GET', '/v1/projects/find', $params);
    }

    /**
     * Bulk retrieval of project records with cursor-based pagination.
     *
     * @param string|null $cursor Cursor from previous request for pagination
     * @param string|null $segment Filter by segment
     * @param string|null $stage Filter by stage
     * @param string|null $scope Filter by scope (team, local, etc.)
     * @param array $additionalParams Additional parameters
     * @return array Project records and next cursor
     */
    public function feed(
        ?string $cursor = null,
        ?string $segment = null,
        ?string $stage = null,
        ?string $scope = null,
        array $additionalParams = []
    ): array {
        $params = $additionalParams;
        if ($cursor) {
            $params['cursor'] = $cursor;
        }
        if ($segment) {
            $params['segment'] = $segment;
        }
        if ($stage) {
            $params['stage'] = $stage;
        }
        if ($scope) {
            $params['scope'] = $scope;
        }

        return $this->client->makeRequest('GET', '/v1/projects/feed', $params);
    }
}

