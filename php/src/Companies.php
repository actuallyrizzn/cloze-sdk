<?php

namespace Cloze\SDK;

/**
 * Companies endpoints.
 */
class Companies
{
    private $client;

    public function __construct(ClozeClient $client)
    {
        $this->client = $client;
    }

    /**
     * Create a new company or enhance an existing one.
     *
     * @param array $company Company data to create
     * @return array Creation result
     */
    public function create(array $company): array
    {
        return $this->client->makeRequest('POST', '/v1/companies/create', null, $company);
    }

    /**
     * Enhance an existing company.
     *
     * @param array $company Company data to update
     * @return array Update result
     */
    public function update(array $company): array
    {
        return $this->client->makeRequest('POST', '/v1/companies/update', null, $company);
    }

    /**
     * Get a company by identifier.
     *
     * @param string $identifier Unique identifier (domain, twitter, email, direct ID, etc.)
     * @param string|null $identifierType Optional type of identifier
     * @return array Company data
     */
    public function get(string $identifier, ?string $identifierType = null): array
    {
        $params = ['identifier' => $identifier];
        if ($identifierType) {
            $params['identifier_type'] = $identifierType;
        }

        return $this->client->makeRequest('GET', '/v1/companies/get', $params);
    }

    /**
     * Delete a company.
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

        return $this->client->makeRequest('DELETE', '/v1/companies/delete', $params);
    }

    /**
     * Find companies with extensive query, sort and group by options.
     *
     * @param array|null $query Query parameters
     * @param int|null $pagenumber Page number for pagination
     * @param int|null $pagesize Page size for pagination
     * @param bool|null $countonly If true, return only count
     * @param array $additionalParams Additional query parameters
     * @return array List of matching companies or count
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

        return $this->client->makeRequest('GET', '/v1/companies/find', $params);
    }

    /**
     * Bulk retrieval of company records with cursor-based pagination.
     *
     * @param string|null $cursor Cursor from previous request for pagination
     * @param string|null $segment Filter by segment
     * @param string|null $stage Filter by stage
     * @param string|null $scope Filter by scope (team, local, etc.)
     * @param array $additionalParams Additional parameters
     * @return array Company records and next cursor
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

        return $this->client->makeRequest('GET', '/v1/companies/feed', $params);
    }
}

