<?php

/**
 * Account endpoints.
 *
 * Copyright (C) 2025 Cloze SDK Contributors
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <https://www.gnu.org/licenses/>.
 */

namespace Cloze\SDK;

class Account
{
    private $client;

    public function __construct(ClozeClient $client)
    {
        $this->client = $client;
    }

    /**
     * Get custom fields.
     *
     * @param string|null $relationtype Optional filter - 'person', 'project', or 'company' (or null for all)
     * @return array List of custom fields
     * @throws \Cloze\SDK\Exceptions\ClozeAPIError
     * @throws \Cloze\SDK\Exceptions\ClozeAuthenticationError
     * @throws \Cloze\SDK\Exceptions\ClozeRateLimitError
     */
    public function getFields(?string $relationtype = null): array
    {
        $params = [];
        if ($relationtype) {
            $params['relationtype'] = $relationtype;
        }

        return $this->client->makeRequest('GET', '/v1/user/fields', $params);
    }

    /**
     * Get user profile.
     *
     * @return array User profile information
     * @throws \Cloze\SDK\Exceptions\ClozeAPIError
     * @throws \Cloze\SDK\Exceptions\ClozeAuthenticationError
     * @throws \Cloze\SDK\Exceptions\ClozeRateLimitError
     */
    public function getProfile(): array
    {
        return $this->client->makeRequest('GET', '/v1/user/profile');
    }

    /**
     * Get people contact segments.
     *
     * @return array List of people segments
     * @throws \Cloze\SDK\Exceptions\ClozeAPIError
     * @throws \Cloze\SDK\Exceptions\ClozeAuthenticationError
     * @throws \Cloze\SDK\Exceptions\ClozeRateLimitError
     */
    public function getSegmentsPeople(): array
    {
        return $this->client->makeRequest('GET', '/v1/user/segments/people');
    }

    /**
     * Get project segments.
     *
     * @return array List of project segments
     * @throws \Cloze\SDK\Exceptions\ClozeAPIError
     * @throws \Cloze\SDK\Exceptions\ClozeAuthenticationError
     * @throws \Cloze\SDK\Exceptions\ClozeRateLimitError
     */
    public function getSegmentsProjects(): array
    {
        return $this->client->makeRequest('GET', '/v1/user/segments/projects');
    }

    /**
     * Get people contact stages.
     *
     * @return array List of people stages
     * @throws \Cloze\SDK\Exceptions\ClozeAPIError
     * @throws \Cloze\SDK\Exceptions\ClozeAuthenticationError
     * @throws \Cloze\SDK\Exceptions\ClozeRateLimitError
     */
    public function getStagesPeople(): array
    {
        return $this->client->makeRequest('GET', '/v1/user/stages/people');
    }

    /**
     * Get project stages.
     *
     * @return array List of project stages
     * @throws \Cloze\SDK\Exceptions\ClozeAPIError
     * @throws \Cloze\SDK\Exceptions\ClozeAuthenticationError
     * @throws \Cloze\SDK\Exceptions\ClozeRateLimitError
     */
    public function getStagesProjects(): array
    {
        return $this->client->makeRequest('GET', '/v1/user/stages/projects');
    }

    /**
     * Get steps.
     *
     * @return array List of steps
     * @throws \Cloze\SDK\Exceptions\ClozeAPIError
     * @throws \Cloze\SDK\Exceptions\ClozeAuthenticationError
     * @throws \Cloze\SDK\Exceptions\ClozeRateLimitError
     */
    public function getSteps(): array
    {
        return $this->client->makeRequest('GET', '/v1/user/steps');
    }

    /**
     * Get views and audiences.
     *
     * @return array List of views and audiences
     * @throws \Cloze\SDK\Exceptions\ClozeAPIError
     * @throws \Cloze\SDK\Exceptions\ClozeAuthenticationError
     * @throws \Cloze\SDK\Exceptions\ClozeRateLimitError
     */
    public function getViews(): array
    {
        return $this->client->makeRequest('GET', '/v1/user/views');
    }
}
