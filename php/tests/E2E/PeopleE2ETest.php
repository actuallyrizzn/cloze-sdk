<?php

namespace Cloze\SDK\Tests\E2E;

class PeopleE2ETest extends E2ETestCase
{
    private static ?string $createdPersonId = null;

    public function testCreatePerson(): void
    {
        $person = [
            'email' => 'test_' . time() . '@example.com',
            'first' => 'Test',
            'last' => 'User'
        ];
        
        $result = $this->client->people->create($person);
        $this->assertEquals(0, $result['errorcode']);
        
        if (isset($result['person']['id'])) {
            self::$createdPersonId = $result['person']['id'];
        } elseif (isset($result['person']['email'])) {
            self::$createdPersonId = $result['person']['email'];
        }
    }

    public function testGetPerson(): void
    {
        if (!self::$createdPersonId) {
            $this->markTestSkipped('No person ID from previous test');
        }
        
        $result = $this->client->people->get(self::$createdPersonId);
        $this->assertEquals(0, $result['errorcode']);
        $this->assertArrayHasKey('person', $result);
    }

    public function testUpdatePerson(): void
    {
        if (!self::$createdPersonId) {
            $this->markTestSkipped('No person ID from previous test');
        }
        
        $person = [
            'id' => self::$createdPersonId,
            'first' => 'Updated',
            'last' => 'Name'
        ];
        
        $result = $this->client->people->update($person);
        $this->assertEquals(0, $result['errorcode']);
    }

    public function testFindPerson(): void
    {
        if (!self::$createdPersonId) {
            $this->markTestSkipped('No person ID from previous test');
        }
        
        $result = $this->client->people->find(['email' => self::$createdPersonId], 1, 10, false);
        $this->assertEquals(0, $result['errorcode']);
    }

    public function testDeletePerson(): void
    {
        if (!self::$createdPersonId) {
            $this->markTestSkipped('No person ID from previous test');
        }
        
        $result = $this->client->people->delete(self::$createdPersonId);
        $this->assertEquals(0, $result['errorcode']);
        
        self::$createdPersonId = null;
    }
}

