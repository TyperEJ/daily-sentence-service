<?php

namespace EJLin\Tests\DailySentence;

use EJLin\DailySentence\GuzzleHTTPClient;
use GuzzleHttp\Exception\GuzzleException;
use PHPUnit\Framework\TestCase;

class GuzzleHTTPClientTest extends TestCase
{
    private static $reqMirrorPort;
    private static $reqMirrorPID;

    public static function setUpBeforeClass(): void
    {
        if (defined('PHP_WINDOWS_VERSION_MAJOR')) {
            return;
        }

        if (empty(GuzzleHTTPClientTest::$reqMirrorPort)) {
            $sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
            socket_bind($sock, '127.0.0.1', 0);
            socket_getsockname($sock, $address, GuzzleHTTPClientTest::$reqMirrorPort);
            socket_close($sock);
        }

        if (empty(GuzzleHTTPClientTest::$reqMirrorPID)) {
            $out = [];
            $cmd = sprintf(
                'nohup %s:%d %s > /dev/null & echo $!',
                'php -S 127.0.0.1',
                GuzzleHTTPClientTest::$reqMirrorPort,
                __DIR__ . '/../req_mirror.php'
            );
            exec($cmd, $out);
            GuzzleHTTPClientTest::$reqMirrorPID = $out[0];
            sleep(1); // Need to wait server to be ready to accept connection
        }
    }

    public static function tearDownAfterClass(): void
    {
        if (!empty(GuzzleHTTPClientTest::$reqMirrorPID)) {
            posix_kill(GuzzleHTTPClientTest::$reqMirrorPID, 9);
        }
    }

    protected function setUp(): void
    {
        if (defined('PHP_WINDOWS_VERSION_MAJOR')) {
            $this->markTestSkipped("These tests don't support Windows environment for now.");
        }

        if (empty(GuzzleHTTPClientTest::$reqMirrorPID)) {
            $this->fail('Mirror server looks dead');
        }
    }

    /**
     * @throws GuzzleException
     */
    public function testGet()
    {
        $curl = new GuzzleHTTPClient();
        $res = $curl->get('127.0.0.1:' . GuzzleHTTPClientTest::$reqMirrorPort . '/foo/bar');
        $body = $res->getJSONDecodedBody();
        $this->assertNotNull($body);
        $this->assertEquals('GET', $body['_SERVER']['REQUEST_METHOD']);
        $this->assertEquals('/foo/bar', $body['_SERVER']['SCRIPT_NAME']);
        $this->assertEquals('', $body['Body']);
    }
}
