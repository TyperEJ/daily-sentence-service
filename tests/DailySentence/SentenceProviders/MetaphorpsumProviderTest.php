<?php

namespace EJLin\Tests\DailySentence\SentenceProviders;

use EJLin\DailySentence\SentenceProviders\MetaphorpsumProvider;
use EJLin\Tests\DailySentence\Util\DummyHttpClient;
use PHPUnit\Framework\TestCase;

class MetaphorpsumProviderTest extends TestCase
{
    public function testGetSentence()
    {
        $mock = function ($testRunner, $httpMethod, $url) {
            /** @var \PHPUnit\Framework\TestCase $testRunner */
            $testRunner->assertEquals('GET', $httpMethod);
            $testRunner->assertEquals('http://metaphorpsum.com/sentences/3', $url);

            return "An apple a day, keeps the doctor away.";
        };

        $itsthisforthatProvider = new MetaphorpsumProvider(new DummyHttpClient($this,$mock));

        $sentence = $itsthisforthatProvider->getSentence();

        $this->assertEquals("An apple a day, keeps the doctor away.", $sentence);
    }
}