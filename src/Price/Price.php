<?php

namespace Walmart\Price;

use Walmart\Requests\UpdatePriceRequest;

class Price
{
    public function UpdatePrice($config, $requestParams)
    {
        $request = new UpdatePriceRequest($config, $requestParams);
        return $request->sendRequest()->parseResponse();
    }
}
