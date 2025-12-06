<?php

/**
 * Webhooks endpoints.
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

use Cloze\SDK\Exceptions\ClozeValidationError;
class Webhooks
{
    private $client;

    public function __construct(ClozeClient $client)
    {
        $this->client = $client;
    }

    /**
     * List all webhook subscriptions.
     *
     * @return array List of webhook subscriptions
     */
    public function list(): array
    {
        return $this->client->makeRequest('GET', '/v1/webhooks');
    }

    /**
     * Subscribe to change events.
     *
     * @param string $event Event type (person.change, project.change, company.change,
     *                      person.audit.change, project.audit.change, company.audit.change)
     * @param string $targetUrl Callback URL for webhook notifications
     * @param string|null $scope Subscription scope (local, team, hierarchy:/X/Y/Z, hierarchy:/X/Y/Z/*)
     * @param array|null $filters List of filter objects for filtering notifications
     * @param string|null $clientType Optional client implementation information (e.g., "human")
     * @param string|null $clientReference Optional client-provided name for the subscription
     * @param int|null $ttl Optional time-to-live for subscription in seconds
     * @return array Subscription information with uniqueid
     */
    public function subscribe(
        string $event,
        string $targetUrl,
        ?string $scope = null,
        ?array $filters = null,
        ?string $clientType = null,
        ?string $clientReference = null,
        ?int $ttl = null
    ): array {
        $subscription = [
            'event' => $event,
            'target_url' => $targetUrl,
        ];

        if ($scope) {
            $subscription['scope'] = $scope;
        }
        if ($filters) {
            $subscription['filters'] = $filters;
        }
        if ($clientType) {
            $subscription['client_type'] = $clientType;
        }
        if ($clientReference) {
            $subscription['client_reference'] = $clientReference;
        }
        if ($ttl) {
            $subscription['ttl'] = $ttl;
        }

        return $this->client->makeRequest('POST', '/v1/webhooks/subscribe', null, $subscription);
    }

    /**
     * Cancel a webhook subscription.
     *
     * @param string $event Event type of the subscription to cancel
     * @param string|null $uniqueid Unique subscription identifier (use with event)
     * @param string|null $clientReference Client subscription reference (use with event if provided during subscribe)
     * @return array Unsubscribe result
     * @throws ClozeValidationError
     */
    public function unsubscribe(
        string $event,
        ?string $uniqueid = null,
        ?string $clientReference = null
    ): array {
        if (!$uniqueid && !$clientReference) {
            throw new ClozeValidationError('Either uniqueid or clientReference must be provided');
        }

        $subscription = ['event' => $event];
        if ($uniqueid) {
            $subscription['uniqueid'] = $uniqueid;
        }
        if ($clientReference) {
            $subscription['client_reference'] = $clientReference;
        }

        return $this->client->makeRequest('POST', '/v1/webhooks/unsubscribe', null, $subscription);
    }
}

