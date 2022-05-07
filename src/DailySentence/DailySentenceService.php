<?php

namespace EJLin\DailySentence;

use EJLin\DailySentence\SentenceProviders\SentenceProvider;

/**
 * DailySentenceService
 */
class DailySentenceService
{
    /**
     * @var SentenceProvider
     */
    protected $sentenceProvider;

    /**
     * @param SentenceProvider $sentenceProvider
     */
    public function __construct(SentenceProvider $sentenceProvider)
    {
        $this->sentenceProvider = $sentenceProvider;
    }

    /**
     * @param SentenceProvider $sentenceProvider
     */
    public function setSentenceProvider(SentenceProvider $sentenceProvider)
    {
        $this->sentenceProvider = $sentenceProvider;
    }

    /**
     * @return string
     */
    public function getSentence(): string
    {
        return $this->sentenceProvider->getSentence();
    }
}