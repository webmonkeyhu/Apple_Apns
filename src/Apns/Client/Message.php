<?php

declare(strict_types=1);

namespace Webmonkey\Apple\Apns\Client;

use Webmonkey\Apple\Exception;
use Webmonkey\Apple\Apns\Message as ApnsMessage;
use Webmonkey\Apple\Apns\Response\Message as MessageResponse;

class Message extends AbstractClient
{
    /**
     * APNS URIs
     * @var array
     */
    protected $uris = [
        'tlsv1.2://gateway.sandbox.push.apple.com:2195',
        'tlsv1.2://gateway.push.apple.com:2195',
    ];

    /**
     * Send Message
     *
     * @param  ApnsMessage     $message
     * @return MessageResponse
     */
    public function send(ApnsMessage $message)
    {
        if (! $this->isConnected()) {
            throw new Exception\RuntimeException('You must first open the connection by calling open()');
        }

        $ret = $this->write($message->getPayloadJson());
        if ($ret === false) {
            throw new Exception\RuntimeException('Server is unavailable; please retry later');
        }

        return new MessageResponse($this->read());
    }
}
