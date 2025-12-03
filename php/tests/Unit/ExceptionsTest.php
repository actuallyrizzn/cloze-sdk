<?php

namespace Cloze\SDK\Tests\Unit;

use Cloze\SDK\Exceptions\ClozeAPIError;
use Cloze\SDK\Exceptions\ClozeAuthenticationError;
use Cloze\SDK\Exceptions\ClozeRateLimitError;
use Cloze\SDK\Exceptions\ClozeValidationError;

class ExceptionsTest extends TestCase
{
    public function testClozeAPIError(): void
    {
        $error = new ClozeAPIError('Test error', 1);
        $this->assertEquals('Test error', $error->getMessage());
        $this->assertEquals(1, $error->getErrorcode());
        $this->assertNull($error->getResponse());
    }

    public function testClozeAPIErrorWithResponse(): void
    {
        $response = new \stdClass();
        $error = new ClozeAPIError('Test error', 1, $response);
        $this->assertEquals($response, $error->getResponse());
    }

    public function testClozeAPIErrorWithoutErrorcode(): void
    {
        $error = new ClozeAPIError('Test error');
        $this->assertNull($error->getErrorcode());
    }

    public function testClozeAuthenticationError(): void
    {
        $error = new ClozeAuthenticationError('Auth failed');
        $this->assertInstanceOf(ClozeAPIError::class, $error);
        $this->assertEquals('Auth failed', $error->getMessage());
    }

    public function testClozeRateLimitError(): void
    {
        $error = new ClozeRateLimitError('Rate limit exceeded');
        $this->assertInstanceOf(ClozeAPIError::class, $error);
        $this->assertEquals('Rate limit exceeded', $error->getMessage());
    }

    public function testClozeValidationError(): void
    {
        $error = new ClozeValidationError('Validation failed');
        $this->assertInstanceOf(ClozeAPIError::class, $error);
        $this->assertEquals('Validation failed', $error->getMessage());
    }
}

