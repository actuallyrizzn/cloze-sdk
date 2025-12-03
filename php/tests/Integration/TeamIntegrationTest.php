<?php

namespace Cloze\SDK\Tests\Integration;

class TeamIntegrationTest extends IntegrationTestCase
{
    public function testListMembers(): void
    {
        $result = $this->client->team->listMembers();
        $this->assertArrayHasKey('errorcode', $result);
    }

    public function testGetNodes(): void
    {
        $result = $this->client->team->getNodes();
        $this->assertArrayHasKey('errorcode', $result);
    }

    public function testGetRoles(): void
    {
        $result = $this->client->team->getRoles();
        $this->assertArrayHasKey('errorcode', $result);
    }
}

