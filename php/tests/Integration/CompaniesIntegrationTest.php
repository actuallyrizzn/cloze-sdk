<?php

namespace Cloze\SDK\Tests\Integration;

class CompaniesIntegrationTest extends IntegrationTestCase
{
    public function testFind(): void
    {
        $result = $this->client->companies->find();
        $this->assertArrayHasKey('errorcode', $result);
    }

    public function testFeed(): void
    {
        $result = $this->client->companies->feed();
        $this->assertArrayHasKey('errorcode', $result);
    }
}

