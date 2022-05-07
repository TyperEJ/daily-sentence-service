<?php

namespace EJLin\Tests\DailySentence\SentenceProviders;

use EJLin\DailySentence\SentenceProviders\ItsthisforthatProvider;
use EJLin\Tests\DailySentence\Util\DummyHttpClient;
use PHPUnit\Framework\TestCase;

class ItsthisforthatProviderTest extends TestCase
{
    public function testGetSentence()
    {
        $mock = function ($testRunner, $httpMethod, $url, $data, $header) {
            /** @var \PHPUnit\Framework\TestCase $testRunner */
            $testRunner->assertEquals('GET', $httpMethod);
            $testRunner->assertEquals('https://itsthisforthat.com/api.php?text', $url);

            return "So, Basically, It's Like A Appstore for Cracked iPhone Apps.";
        };

        $itsthisforthatProvider = new ItsthisforthatProvider(new DummyHttpClient($this,$mock));

        $sentence = $itsthisforthatProvider->getSentence();

        $this->assertEquals("So, Basically, It's Like A Appstore for Cracked iPhone Apps.", $sentence);
    }
}
