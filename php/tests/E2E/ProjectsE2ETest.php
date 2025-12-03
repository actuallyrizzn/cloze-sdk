<?php

namespace Cloze\SDK\Tests\E2E;

class ProjectsE2ETest extends E2ETestCase
{
    private static ?string $createdProjectId = null;

    public function testCreateProject(): void
    {
        $project = [
            'name' => 'Test Project ' . time()
        ];
        
        $result = $this->client->projects->create($project);
        $this->assertEquals(0, $result['errorcode']);
        
        if (isset($result['project']['id'])) {
            self::$createdProjectId = $result['project']['id'];
        } elseif (isset($result['project']['name'])) {
            self::$createdProjectId = $result['project']['name'];
        }
    }

    public function testGetProject(): void
    {
        if (!self::$createdProjectId) {
            $this->markTestSkipped('No project ID from previous test');
        }
        
        $result = $this->client->projects->get(self::$createdProjectId);
        $this->assertEquals(0, $result['errorcode']);
        $this->assertArrayHasKey('project', $result);
    }

    public function testUpdateProject(): void
    {
        if (!self::$createdProjectId) {
            $this->markTestSkipped('No project ID from previous test');
        }
        
        $project = [
            'id' => self::$createdProjectId,
            'name' => 'Updated Project Name'
        ];
        
        $result = $this->client->projects->update($project);
        $this->assertEquals(0, $result['errorcode']);
    }

    public function testDeleteProject(): void
    {
        if (!self::$createdProjectId) {
            $this->markTestSkipped('No project ID from previous test');
        }
        
        $result = $this->client->projects->delete(self::$createdProjectId);
        $this->assertEquals(0, $result['errorcode']);
        
        self::$createdProjectId = null;
    }
}

