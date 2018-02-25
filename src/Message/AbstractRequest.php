<?php

namespace Paysterify\Message;

use GuzzleHttp\Client;

abstract class AbstractRequest
{
    /**
     * Holding the request parameters.
     *
     * @var array
     */
    protected $parameters;

    /**
     * Create a new request instance
     *
     * @return void
     */
    public function __construct()
    {
        $this->httpClient = new Client;
    }

    /**
     * Set the request parameters.
     *
     * @param  string $parameters
     * @return AbstractRequest
     */
    public function setParameters($parameters)
    {
        $this->parameters = $parameters;

        return $this;
    }

    /**
     * Get the request url.
     *
     * @param  string $path
     * @return string
     */
    public function url($path = null)
    {
        return url(
            ((isset($this->parameters['config']['sandbox']) && $this->parameters['config']['sandbox']) ? static::API_BASE_URL_SANDBOX : static::API_BASE_URL_LIVE) .
            ($path ? DIRECTORY_SEPARATOR . $path : '')
        );
    }
}
