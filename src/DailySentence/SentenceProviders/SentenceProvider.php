<?php

namespace EJLin\DailySentence\SentenceProviders;

/**
 * SentenceProvider
 */
abstract class SentenceProvider
{
    /**
     * @return string
     */
    abstract public function getSentence(): string;
}