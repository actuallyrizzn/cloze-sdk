<?php

namespace Cloze\SDK;

/**
 * Timeline endpoints.
 */
class Timeline
{
    private $client;

    public function __construct(ClozeClient $client)
    {
        $this->client = $client;
    }

    /**
     * Create a communication timeline item.
     *
     * @param array $communication Communication data
     * @return array Creation result
     */
    public function createCommunication(array $communication): array
    {
        return $this->client->makeRequest(
            'POST',
            '/v1/timeline/communication/create',
            null,
            $communication
        );
    }

    /**
     * Create a content timeline item.
     *
     * @param array $content Content data
     * @return array Creation result
     */
    public function createContent(array $content): array
    {
        return $this->client->makeRequest(
            'POST',
            '/v1/timeline/content/create',
            null,
            $content
        );
    }

    /**
     * Create a todo timeline item.
     *
     * @param array $todo Todo data
     * @return array Creation result
     */
    public function createTodo(array $todo): array
    {
        return $this->client->makeRequest(
            'POST',
            '/v1/timeline/todo/create',
            null,
            $todo
        );
    }

    /**
     * Retrieve email opens.
     *
     * @param int|null $fromTimestamp UTC ms timestamp for first message to retrieve
     * @param string|null $user User identifier
     * @return array Message opens data
     */
    public function getMessageOpens(?int $fromTimestamp = null, ?string $user = null): array
    {
        $params = [];
        if ($fromTimestamp !== null) {
            $params['from'] = $fromTimestamp;
        }
        if ($user) {
            $params['user'] = $user;
        }

        return $this->client->makeRequest('GET', '/v1/messages/opens', $params);
    }
}

