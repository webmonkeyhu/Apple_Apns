<?php

declare(strict_types=1);

namespace WebmonkeyTest\Apple\Apns\TestAsset;

use Webmonkey\Apple\Apns\Exception;
use Webmonkey\Apple\Apns\Client\Message as MonkeyMessageClient;

class MessageClient extends MonkeyMessageClient
{
    /**
     * Read Response
     *
     * @var string
     */
    protected $readResponse;

    /**
     * Write Response
     *
     * @var mixed
     */
    protected $writeResponse;

    /**
     * Set the Response
     *
     * @param  string        $str
     * @return MessageClient
     */
    public function setReadResponse($str)
    {
        $this->readResponse = $str;

        return $this;
    }

    /**
     * Set the write response
     *
     * @param  mixed         $resp
     * @return MessageClient
     */
    public function setWriteResponse($resp)
    {
        $this->writeResponse = $resp;

        return $this;
    }

    /**
     * Connect to Host
     *
     * @return MessageClient
     */
    protected function connect($host, array $ssl)
    {
        return $this;
    }

    /**
     * Return Response
     *
     * @param  string $length
     * @return string
     */
    protected function read($length = 1024)
    {
        if (! $this->isConnected()) {
            throw new Exception\RuntimeException('You must open the connection prior to reading data');
        }

        if ($this->readResponse === null) {
            return null;
        }

        $ret = substr($this->readResponse, 0, $length);
        $this->readResponse = null;

        return $ret;
    }

    /**
     * Write and Return Length
     *
     * @param  string $payload
     * @return int
     */
    protected function write($payload)
    {
        if (! $this->isConnected()) {
            throw new Exception\RuntimeException('You must open the connection prior to writing data');
        }

        if ($this->readResponse === null) {
            return null;
        }

        $ret = $this->writeResponse;
        $this->writeResponse = null;

        return (null === $ret) ? strlen($payload) : $ret;
    }
}
