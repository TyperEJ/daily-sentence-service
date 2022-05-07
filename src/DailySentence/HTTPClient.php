<?php

namespace EJLin\DailySentence;

/**
 * HTTPClient
 */
interface HTTPClient
{
    /**
     * Sends GET request
     *
     * @param string $url Request URL.
     * @return Response Response of API request.
     */
    public function get(string $url): Response;
}
