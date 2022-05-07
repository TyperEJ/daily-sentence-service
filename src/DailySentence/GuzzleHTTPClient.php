<?php

namespace EJLin\DailySentence;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use EJLin\DailySentence\Exceptions\HTTPClientException;
use EJLin\DailySentence\Exceptions\SentenceProviderException;

/**
 * GuzzleHTTPClient
 */
class GuzzleHTTPClient implements HTTPClient
{
    /**
     * @var Client
     */
    protected $guzzleClient;

    public function __construct()
    {
        $this->guzzleClient = new Client();
    }

    /**
     * @param string $url
     * @return Response
     * @throws HTTPClientException
     * @throws SentenceProviderException
     */
    public function get(string $url): Response
    {
        try {

            $response = $this->guzzleClient->get($url);

        } catch (ClientException $clientException) {

            $response = $clientException->getResponse();

            throw new SentenceProviderException($response->getBody()->getContents());

        } catch (GuzzleException $guzzleException) {

            throw new HTTPClientException($guzzleException->getMessage());

        }

        return new Response(
            $response->getStatusCode(),
            $response->getBody()->getContents(),
            $response->getHeaders()
        );
    }
}