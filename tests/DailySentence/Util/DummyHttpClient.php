<?php

namespace EJLin\Tests\DailySentence\Util;

use EJLin\DailySentence\HTTPClient;
use EJLin\DailySentence\Response;
use PHPUnit\Framework\TestCase;

class DummyHttpClient implements HTTPClient
{
    /** @var \PHPUnit\Framework\TestCase */
    private $testRunner;
    /** @var \Closure */
    private $mock;
    /** @var int */
    private $statusCode;

    public function __construct(TestCase $testRunner, \Closure $mock, $statusCode = 200)
    {
        $this->testRunner = $testRunner;
        $this->mock = $mock;
        $this->statusCode = $statusCode;
    }

    /**
     * @param string $url
     * @param array $data Optional
     * @param array $headers
     * @return Response
     */
    public function get(string $url): Response
    {
        $ret = call_user_func($this->mock, $this->testRunner, 'GET', $url);
        return new Response($this->statusCode, $ret);
    }
}
