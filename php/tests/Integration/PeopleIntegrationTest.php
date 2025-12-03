<?php

namespace Cloze\SDK\Tests\Integration;

class PeopleIntegrationTest extends IntegrationTestCase
{
    public function testFind(): void
    {
        $result = $this->client->people->find();
        $this->assertArrayHasKey('errorcode', $result);
    }

    public function testFeed(): void
    {
        $result = $this->client->people->feed();
        $this->assertArrayHasKey('errorcode', $result);
    }
}

