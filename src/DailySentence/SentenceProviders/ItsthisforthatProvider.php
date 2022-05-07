<?php

namespace EJLin\DailySentence\SentenceProviders;

use EJLin\DailySentence\HTTPClient;

/**
 * ItsthisforthatProvider
 */
class ItsthisforthatProvider extends SentenceProvider
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
    public function getSentence() :string
    {
        return $this->httpClient
            ->get('https://itsthisforthat.com/api.php?text',null)
            ->getRawBody();
    }
}