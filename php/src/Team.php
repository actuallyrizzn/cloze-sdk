<?php

namespace Cloze\SDK;

/**
 * Team endpoints.
 */
class Team
{
    private $client;

    public function __construct(ClozeClient $client)
    {
        $this->client = $client;
    }

    /**
     * List team members.
     *
     * @return array List of team members
     */
    public function listMembers(): array
    {
        return $this->client->makeRequest('GET', '/v1/team/members/list');
    }

    /**
     * Update team members.
     *
     * @param array $members List of team member updates
     * @return array Update result
     */
    public function updateMembers(array $members): array
    {
        return $this->client->makeRequest(
            'POST',
            '/v1/team/members/update',
            null,
            ['members' => $members]
        );
    }

    /**
     * Get team organizational nodes.
     *
     * @return array Team nodes structure
     */
    public function getNodes(): array
    {
        return $this->client->makeRequest('GET', '/v1/team/nodes');
    }

    /**
     * Get team roles.
     *
     * @return array List of team roles with names and IDs
     */
    public function getRoles(): array
    {
        return $this->client->makeRequest('GET', '/v1/team/roles');
    }
}

