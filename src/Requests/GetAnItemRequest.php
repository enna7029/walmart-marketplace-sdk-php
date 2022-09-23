<?php

namespace Walmart\Requests;

use Walmart\Responses\ItemResponse;

class GetAnItemRequest extends BasicRequest
{
    public function __construct($config, $sku)
    {
        parent::__construct($config);
        $this->init($sku);
    }

    public function init($sku)
    {
        $this->method = "GET";
        $this->url = "https://marketplace.walmartapis.com/v3/items/".urlencode($sku);

        $this->query = ["productIdType" => "SKU"];
        $this->body = [];
        $this->bodyType = "none";
    }

    public function initHeader()
    {
        parent::initHeader();
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
        return new ItemResponse($this->responseData["ItemResponse"][0]);
    }
}
