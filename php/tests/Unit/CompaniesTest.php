<?php

namespace Cloze\SDK\Tests\Unit;

use Cloze\SDK\ClozeClient;

class CompaniesTest extends TestCase
{
    private function getCompanies($client)
    {
        return $client->companies;
    }

    public function testCreate(): void
    {
        $client = $this->createMockClient(['makeRequest']);
        $company = ['name' => 'Test Company'];
        $client->expects($this->once())
            ->method('makeRequest')
            ->with('POST', '/v1/companies/create', null, $company)
            ->willReturn(['errorcode' => 0]);
        
        $this->getCompanies($client)->create($company);
    }

    public function testUpdate(): void
    {
        $client = $this->createMockClient(['makeRequest']);
        $company = ['name' => 'Updated Company'];
        $client->expects($this->once())
            ->method('makeRequest')
            ->with('POST', '/v1/companies/update', null, $company)
            ->willReturn(['errorcode' => 0]);
        
        $this->getCompanies($client)->update($company);
    }

    public function testGet(): void
    {
        $client = $this->createMockClient(['makeRequest']);
        $client->expects($this->once())
            ->method('makeRequest')
            ->with('GET', '/v1/companies/get', ['identifier' => 'example.com'])
            ->willReturn(['errorcode' => 0, 'company' => []]);
        
        $this->getCompanies($client)->get('example.com');
    }

    public function testGetWithIdentifierType(): void
    {
        $client = $this->createMockClient(['makeRequest']);
        $client->expects($this->once())
            ->method('makeRequest')
            ->with('GET', '/v1/companies/get', ['identifier' => 'example.com', 'identifier_type' => 'domain'])
            ->willReturn(['errorcode' => 0, 'company' => []]);
        
        $this->getCompanies($client)->get('example.com', 'domain');
    }

    public function testDelete(): void
    {
        $client = $this->createMockClient(['makeRequest']);
        $client->expects($this->once())
            ->method('makeRequest')
            ->with('DELETE', '/v1/companies/delete', ['identifier' => 'example.com'])
            ->willReturn(['errorcode' => 0]);
        
        $this->getCompanies($client)->delete('example.com');
    }

    public function testDeleteWithIdentifierType(): void
    {
        $client = $this->createMockClient(['makeRequest']);
        $client->expects($this->once())
            ->method('makeRequest')
            ->with('DELETE', '/v1/companies/delete', ['identifier' => 'example.com', 'identifier_type' => 'domain'])
            ->willReturn(['errorcode' => 0]);
        
        $this->getCompanies($client)->delete('example.com', 'domain');
    }

    public function testFind(): void
    {
        $client = $this->createMockClient(['makeRequest']);
        $client->expects($this->once())
            ->method('makeRequest')
            ->with('GET', '/v1/companies/find', [])
            ->willReturn(['errorcode' => 0, 'list' => []]);
        
        $this->getCompanies($client)->find();
    }

    public function testFindWithParams(): void
    {
        $client = $this->createMockClient(['makeRequest']);
        $client->expects($this->once())
            ->method('makeRequest')
            ->with(
                'GET',
                '/v1/companies/find',
                $this->callback(function ($params) {
                    return isset($params['pagenumber']) && isset($params['countonly']);
                })
            )
            ->willReturn(['errorcode' => 0, 'list' => []]);
        
        $this->getCompanies($client)->find(['segment' => 'test'], 1, 10, false);
    }

    public function testFindWithAdditionalParams(): void
    {
        $client = $this->createMockClient(['makeRequest']);
        $client->expects($this->once())
            ->method('makeRequest')
            ->with(
                'GET',
                '/v1/companies/find',
                $this->callback(function ($params) {
                    return isset($params['sort']) && isset($params['group']);
                })
            )
            ->willReturn(['errorcode' => 0, 'list' => []]);
        
        $this->getCompanies($client)->find(null, null, null, null, ['sort' => 'name', 'group' => 'segment']);
    }

    public function testFeed(): void
    {
        $client = $this->createMockClient(['makeRequest']);
        $client->expects($this->once())
            ->method('makeRequest')
            ->with('GET', '/v1/companies/feed', [])
            ->willReturn(['errorcode' => 0, 'list' => []]);
        
        $this->getCompanies($client)->feed();
    }

    public function testFeedWithParams(): void
    {
        $client = $this->createMockClient(['makeRequest']);
        $client->expects($this->once())
            ->method('makeRequest')
            ->with(
                'GET',
                '/v1/companies/feed',
                $this->callback(function ($params) {
                    return isset($params['cursor']) && isset($params['scope']);
                })
            )
            ->willReturn(['errorcode' => 0, 'list' => []]);
        
        $this->getCompanies($client)->feed('cursor', 'segment', 'stage', 'local');
    }

    public function testFeedWithAdditionalParams(): void
    {
        $client = $this->createMockClient(['makeRequest']);
        $client->expects($this->once())
            ->method('makeRequest')
            ->with(
                'GET',
                '/v1/companies/feed',
                $this->callback(function ($params) {
                    return isset($params['returnauditchanges']);
                })
            )
            ->willReturn(['errorcode' => 0, 'list' => []]);
        
        $this->getCompanies($client)->feed(null, null, null, null, ['returnauditchanges' => true]);
    }
}

