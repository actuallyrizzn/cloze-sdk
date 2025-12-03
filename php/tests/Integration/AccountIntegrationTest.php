<?php

namespace Cloze\SDK\Tests\Integration;

class AccountIntegrationTest extends IntegrationTestCase
{
    public function testGetFields(): void
    {
        $result = $this->client->account->getFields();
        $this->assertArrayHasKey('errorcode', $result);
    }

    public function testGetFieldsWithRelationtype(): void
    {
        $result = $this->client->account->getFields('person');
        $this->assertArrayHasKey('errorcode', $result);
    }

    public function testGetProfile(): void
    {
        $result = $this->client->account->getProfile();
        $this->assertArrayHasKey('errorcode', $result);
    }

    public function testGetSegmentsPeople(): void
    {
        $result = $this->client->account->getSegmentsPeople();
        $this->assertArrayHasKey('errorcode', $result);
    }

    public function testGetSegmentsProjects(): void
    {
        $result = $this->client->account->getSegmentsProjects();
        $this->assertArrayHasKey('errorcode', $result);
    }

    public function testGetStagesPeople(): void
    {
        $result = $this->client->account->getStagesPeople();
        $this->assertArrayHasKey('errorcode', $result);
    }

    public function testGetStagesProjects(): void
    {
        $result = $this->client->account->getStagesProjects();
        $this->assertArrayHasKey('errorcode', $result);
    }

    public function testGetSteps(): void
    {
        $result = $this->client->account->getSteps();
        $this->assertArrayHasKey('errorcode', $result);
    }

    public function testGetViews(): void
    {
        $result = $this->client->account->getViews();
        $this->assertArrayHasKey('errorcode', $result);
    }
}

