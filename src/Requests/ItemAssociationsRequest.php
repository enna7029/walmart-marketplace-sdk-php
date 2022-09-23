<?php

namespace Walmart\Requests;

class ItemAssociationsRequest extends BasicRequest
{
    public function __construct($config, $items)
    {
        parent::__construct($config);
        $this->init($items);
    }

    public function init($items)
    {
        $this->method = "POST";
        $this->url = "https://marketplace.walmartapis.com/v3/items/associations";
        $this->body = $this->getBody($items);
        $this->bodyType = "raw";
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

    public function getBody($items)
    {
        $items = json_encode($items);
        return $items;
    }
}