<?php

namespace Cloze\SDK\Tests\Integration;

use Cloze\SDK\Exceptions\ClozeAPIError;

class TeamIntegrationTest extends IntegrationTestCase
{
    public function testListMembers(): void
    {
        $result = $this->client->team->listMembers();
        $this->assertArrayHasKey('errorcode', $result);
    }

    public function testGetNodes(): void
    {
        try {
            $result = $this->client->team->getNodes();
            $this->assertArrayHasKey('errorcode', $result);
        } catch (ClozeAPIError $e) {
            // Account may not be a team member
            if (strpos($e->getMessage(), 'not a member of a team') !== false) {
                $this->markTestSkipped('Account is not a team member');
            }
            throw $e;
        }
    }

    public function testGetRoles(): void
    {
        try {
            $result = $this->client->team->getRoles();
            $this->assertArrayHasKey('errorcode', $result);
        } catch (ClozeAPIError $e) {
            // Account may not be a team member
            if (strpos($e->getMessage(), 'not a member of a team') !== false) {
                $this->markTestSkipped('Account is not a team member');
            }
            throw $e;
        }
    }
}

