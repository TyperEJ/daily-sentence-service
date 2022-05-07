<?php

namespace EJLin\Tests\DailySentence;

use EJLin\DailySentence\DailySentenceService;
use EJLin\DailySentence\SentenceProviders\ItsthisforthatProvider;
use EJLin\DailySentence\SentenceProviders\MetaphorpsumProvider;
use PHPUnit\Framework\TestCase;

class DailySentenceServiceTest extends TestCase
{
    protected function makeMetaphorpsumProvider()
    {
        $metaphorpsumProvider = $this->createStub(MetaphorpsumProvider::class);

        $metaphorpsumProvider->method('getSentence')
            ->willReturn('An apple a day, keeps the doctor away.');

        return $metaphorpsumProvider;
    }

    protected function makeItsthisforthatProvider()
    {
        $itsthisforthatProvider = $this->createStub(ItsthisforthatProvider::class);

        $itsthisforthatProvider->method('getSentence')
            ->willReturn("So, Basically, It's Like A Appstore for Cracked iPhone Apps.");

        return $itsthisforthatProvider;
    }

    public function testGetMetaphorpsumSentence()
    {
        $metaphorpsumProvider = $this->makeMetaphorpsumProvider();

        $dailySentenceService = new DailySentenceService($metaphorpsumProvider);

        $sentence = $dailySentenceService->getSentence();

        $this->assertEquals('An apple a day, keeps the doctor away.', $sentence);
    }

    public function testGetItsthisforthatSentence()
    {
        $itsthisforthatProvider = $this->makeItsthisforthatProvider();

        $dailySentenceService = new DailySentenceService($itsthisforthatProvider);

        $sentence = $dailySentenceService->getSentence();

        $this->assertEquals("So, Basically, It's Like A Appstore for Cracked iPhone Apps.", $sentence);
    }

    public function testSetSentenceProvider()
    {
        $itsthisforthatProvider = $this->makeItsthisforthatProvider();

        $dailySentenceService = new DailySentenceService($itsthisforthatProvider);

        $metaphorpsumProvider = $this->makeMetaphorpsumProvider();

        $dailySentenceService->setSentenceProvider($metaphorpsumProvider);

        $sentence = $dailySentenceService->getSentence();

        $this->assertEquals("An apple a day, keeps the doctor away.", $sentence);
    }
}