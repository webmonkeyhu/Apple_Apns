<?php

declare(strict_types=1);

namespace Webmonkey\Apple\Apns\Client;

use Webmonkey\Apple\Exception;
use Webmonkey\Apple\Apns\Response\Feedback as FeedbackResponse;

/**
 * Feedback Client
 */
class Feedback extends AbstractClient
{
    /**
     * APNS URIs
     * @var array
     */
    protected $uris = [
        'tlsv1.2://feedback.sandbox.push.apple.com:2196',
        'tlsv1.2://feedback.push.apple.com:2196'
    ];

    /**
     * Get Feedback
     *
     * @return array of Webmonkey\Apple\Apns\Response\Feedback
     */
    public function feedback()
    {
        if (! $this->isConnected()) {
            throw new Exception\RuntimeException('You must first open the connection by calling open()');
        }

        $tokens = [];
        while ($token = $this->read(38)) {
            $tokens[] = new FeedbackResponse($token);
        }

        return $tokens;
    }
}
