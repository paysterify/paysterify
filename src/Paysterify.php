<?php

namespace Paysterify;

use Exception;

class Paysterify
{
    /**
     * Holding the current gateway.
     *
     * @var string
     */
    protected $gateway;

    /**
     * Holding the latest request response.
     *
     * @var object
     */
    protected $response;

    /**
     * Indicates if the gateway should run in sandbox mode.
     *
     * @var boolean
     */
    protected $sandbox;

    /**
     * Holding the gateway config.
     *
     * @var array
     */
    protected $config;

    /**
     * Resolve given gateway alias.
     *
     * @param  string  $gateway
     * @return Paysterify
     */
    public function gateway($gateway)
    {
        try {
            $this->gateway = resolve($gateway);
        } catch (\ReflectionException $e) {
            throw new Exception("[$gateway] Invalid gateway.");
        }

        return $this;
    }

    /**
     * Set the config for gateway.
     *
     * @param  array $config
     * @return Paysterify
     */
    public function configure(array $config)
    {
        $this->config = $config;

        $this->gateway->configure($config);

        return $this;
    }

    /**
     * Authorize the gateway.
     *
     * @param  array  $config
     * @return Paysterify
     */
    public function authorize(array $config = null)
    {
        $this->response = $this->gateway->authorize();

        $this->gateway->response = $this->response;

        return $this;
    }

    /**
     * Perform the payment request.
     *
     * @return Paysterify
     */
    public function purchase()
    {
        $this->response = $this->gateway->purchase();

        $this->gateway->response = $this->response;

        return $this;
    }

    /**
     * Overwrite default magic __call method.
     *
     * @param  string $method
     * @param  array $arguments
     * @return mixed
     */
    public function __call($method, $arguments)
    {
        if (!method_exists($this, $method)) {
            return call_user_func_array([$this->gateway, $method], $arguments);
        }
    }

    /**
     * Assert if the gateway should run in sandbox mode.
     *
     * @param  boolean $enabled
     * @return Paysterify
     */
    public function sandbox($enabled)
    {
        $this->sandbox = $enabled;

        $this->gateway->sandbox = $enabled;

        return $this;
    }

    /**
     * Perform a complete purchase request.
     *
     * @param  array $params
     * @return Paysterify
     */
    public function completePurchase($params = [])
    {
        $this->response = $this->gateway->completePurchase($params);

        $this->gateway->response = $this->response;

        return $this;
    }

    /**
     * Assert if the payment is completed.
     *
     * @return boolean
     */
    public function isCompleted()
    {
        return $this->gateway->isCompleted();
    }
}
