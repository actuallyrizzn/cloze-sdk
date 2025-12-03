<?php

namespace Cloze\SDK\Tests\Integration;

class TimelineIntegrationTest extends IntegrationTestCase
{
    public function testGetMessageOpens(): void
    {
        $result = $this->client->timeline->getMessageOpens();
        $this->assertArrayHasKey('errorcode', $result);
    }
}

