<?php

namespace Cloze\SDK\Tests\Integration;

class ProjectsIntegrationTest extends IntegrationTestCase
{
    public function testFind(): void
    {
        $result = $this->client->projects->find();
        $this->assertArrayHasKey('errorcode', $result);
    }

    public function testFeed(): void
    {
        $result = $this->client->projects->feed();
        $this->assertArrayHasKey('errorcode', $result);
    }
}

