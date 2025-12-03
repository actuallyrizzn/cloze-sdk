<?php

namespace Cloze\SDK;

use Cloze\SDK\Exceptions\ClozeAPIError;
use Cloze\SDK\Exceptions\ClozeAuthenticationError;
use Cloze\SDK\Exceptions\ClozeRateLimitError;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

/**
 * Main client for interacting with the Cloze API.
 */
class ClozeClient
{
    const BASE_URL = 'https://api.cloze.com';
    const API_VERSION = '2025.10';

    private $apiKey;
    private $oauthToken;
    private $baseUrl;
    private $timeout;
    private $client;

    // Endpoint modules
    public $analytics;
    public $team;
    public $account;
    public $projects;
    public $people;
    public $companies;
    public $timeline;
    public $webhooks;

    /**
     * Initialize the Cloze client.
     *
     * @param string|null $apiKey API key for authentication
     * @param string|null $oauthToken OAuth 2.0 access token
     * @param string|null $baseUrl Custom base URL
     * @param int $timeout Request timeout in seconds
     * @throws \InvalidArgumentException
     */
    public function __construct(
        ?string $apiKey = null,
        ?string $oauthToken = null,
        ?string $baseUrl = null,
        int $timeout = 30
    ) {
        if (!$apiKey && !$oauthToken) {
            throw new \InvalidArgumentException('Either apiKey or oauthToken must be provided');
        }

        $this->apiKey = $apiKey;
        $this->oauthToken = $oauthToken;
        $this->baseUrl = $baseUrl ?: self::BASE_URL;
        $this->timeout = $timeout;

        $this->client = new GuzzleClient([
            'base_uri' => $this->baseUrl,
            'timeout' => $this->timeout,
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'User-Agent' => 'cloze-sdk-php/1.0.0',
            ],
        ]);

        // Set authentication
        if ($this->oauthToken) {
            $this->client = new GuzzleClient([
                'base_uri' => $this->baseUrl,
                'timeout' => $this->timeout,
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'User-Agent' => 'cloze-sdk-php/1.0.0',
                    'Authorization' => 'Bearer ' . $this->oauthToken,
                ],
            ]);
        } elseif ($this->apiKey) {
            $this->client = new GuzzleClient([
                'base_uri' => $this->baseUrl,
                'timeout' => $this->timeout,
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'User-Agent' => 'cloze-sdk-php/1.0.0',
                    'Authorization' => 'Bearer ' . $this->apiKey,
                ],
            ]);
        }

        // Initialize endpoint modules
        $this->analytics = new Analytics($this);
        $this->team = new Team($this);
        $this->account = new Account($this);
        $this->projects = new Projects($this);
        $this->people = new People($this);
        $this->companies = new Companies($this);
        $this->timeline = new Timeline($this);
        $this->webhooks = new Webhooks($this);
    }

    /**
     * Make an HTTP request to the Cloze API.
     *
     * @param string $method HTTP method
     * @param string $endpoint API endpoint path
     * @param array|null $params Query parameters
     * @param array|null $jsonData JSON body data
     * @param bool $useApiKeyParam If true, add api_key as query parameter
     * @return array Response data
     * @throws ClozeAPIError
     */
    public function makeRequest(
        string $method,
        string $endpoint,
        ?array $params = null,
        ?array $jsonData = null,
        bool $useApiKeyParam = false
    ): array {
        $options = [];

        // Prepare query parameters
        if ($params) {
            $options['query'] = $params;
        }
        if ($useApiKeyParam && $this->apiKey && !$this->oauthToken) {
            $options['query']['api_key'] = $this->apiKey;
        }

        // Prepare JSON body
        if ($jsonData) {
            $options['json'] = $jsonData;
        }

        try {
            $response = $this->client->request($method, $endpoint, $options);
            return $this->handleResponse($response);
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                return $this->handleResponse($e->getResponse());
            }
            throw new ClozeAPIError('Request failed: ' . $e->getMessage());
        } catch (GuzzleException $e) {
            throw new ClozeAPIError('Request failed: ' . $e->getMessage());
        }
    }

    /**
     * Handle API response and raise appropriate exceptions.
     *
     * @param ResponseInterface $response Response object
     * @return array Response data
     * @throws ClozeAPIError
     * @throws ClozeAuthenticationError
     * @throws ClozeRateLimitError
     */
    private function handleResponse(ResponseInterface $response): array
    {
        $statusCode = $response->getStatusCode();

        // Handle rate limiting
        if ($statusCode === 429) {
            throw new ClozeRateLimitError('Rate limit exceeded');
        }

        // Handle authentication errors
        if ($statusCode === 401) {
            throw new ClozeAuthenticationError(
                'Authentication failed. Check your API key or OAuth token.'
            );
        }

        // Parse JSON response
        $body = $response->getBody()->getContents();
        $data = json_decode($body, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new ClozeAPIError(
                'Invalid response format. Status: ' . $statusCode
            );
        }

        // Check for API errors in response
        $errorcode = $data['errorcode'] ?? 0;
        if ($errorcode !== 0) {
            $message = $data['message'] ?? 'Unknown API error';
            throw new ClozeAPIError('API error: ' . $message, $errorcode);
        }

        // Return successful response
        return $data;
    }
}

