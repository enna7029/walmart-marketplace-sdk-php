<?php

namespace Walmart\Requests;

use Walmart\Configs\Config;

class UpdatePriceRequest extends BasicRequest
{
    public function __construct($config, $requestParams)
    {
        parent::__construct($config);
        $this->init($requestParams);
    }

    public function init($requestParams)
    {
        $this->method = "PUT";
        $this->url = "https://marketplace.walmartapis.com/v3/price";
        $this->bodyType = "raw";
        $this->body = json_encode($requestParams);
    }

    public function initHeader()
    {
        parent::initHeader();
        $this->header["Content-Type"] = "application/json";
        $this->header["Accept"] = "application/json";
    }

    public function sendRequest()
    {
        parent::sendRequest();
        return $this;
    }

    public function parseResponse()
    {
        $this->responseData = json_decode($this->response, true);
        return $this->responseData;
    }

}
