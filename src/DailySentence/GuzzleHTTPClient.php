<?php

namespace EJLin\DailySentence;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use EJLin\DailySentence\Exceptions\HTTPClientException;
use EJLin\DailySentence\Exceptions\SentenceProviderException;

class GuzzleHTTPClient implements HTTPClient
{
    protected $guzzleClient;

    public function __construct()
    {
        $this->guzzleClient = new Client();
    }

    /**
     * @param string $url
     * @param array $data
     * @param array $headers
     * @return Response
     * @throws HTTPClientException
     * @throws SentenceProviderException
     */
    public function get(string $url, array $data = [], array $headers = [])
    {
        try {
            $response = $this->guzzleClient->get($url, [
                'headers' => $headers,
                'query' => $data,
            ]);
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