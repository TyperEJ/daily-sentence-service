<?php

namespace EJLin\DailySentence;

interface HTTPClient
{
    /**
     * Sends GET request
     *
     * @param string $url Request URL.
     * @param array $data URL parameters.
     * @param array $headers
     * @return Response Response of API request.
     */
    public function get(string $url, array $data = [], array $headers = []);
}
