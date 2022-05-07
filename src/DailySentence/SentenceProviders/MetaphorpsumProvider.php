<?php

namespace EJLin\DailySentence\SentenceProviders;

use EJLin\DailySentence\HTTPClient;

/**
 * MetaphorpsumProvider
 */
class MetaphorpsumProvider extends SentenceProvider
{
    /**
     * @var HTTPClient
     */
    protected $httpClient;

    /**
     * @param HTTPClient $httpClient
     */
    public function __construct(HTTPClient $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * @return string
     */
    public function getSentence(): string
    {
        return $this->httpClient
            ->get('http://metaphorpsum.com/sentences/3')
            ->getRawBody();
    }
}