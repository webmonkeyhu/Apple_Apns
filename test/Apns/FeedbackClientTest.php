<?php

declare(strict_types=1);

namespace WebmonkeyTest\Apple\Apns;

use PHPUnit\Framework\TestCase;
use WebmonkeyTest\Apple\Apns\TestAsset\FeedbackClient;

class FeedbackClientTest extends TestCase
{
    protected function setUp() : void
    {
        $this->apns = new FeedbackClient();
    }

    protected function setupValidBase()
    {
        $this->apns->open(FeedbackClient::SANDBOX_URI, __DIR__ . '/TestAsset/certificate.pem');
    }

    public function testFeedback()
    {
        $this->setupValidBase();

        $time   = time();
        $token  = 'abc123';
        $length = strlen($token) / 2;

        $this->apns->setReadResponse(pack('NnH*', $time, $length, $token));

        $response = $this->apns->feedback();

        $this->assertCount(1, $response);

        $feedback = array_shift($response);

        $this->assertEquals($time, $feedback->getTime());
        $this->assertEquals($token, $feedback->getToken());
    }
}
