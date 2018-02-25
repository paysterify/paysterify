<?php

namespace Paysterify;

use Paysterify\Paypal\Message\TokenRequest;

abstract class AbstractGateway implements GatewayInterface
{
    public function request($request, $parameters = [])
    {
        $request = app($request)->setParameters($parameters);

        $response = $request->send();

        return $response;
    }
}
