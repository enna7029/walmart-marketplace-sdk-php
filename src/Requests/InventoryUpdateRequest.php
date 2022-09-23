<?php

namespace Walmart\Requests;

class InventoryUpdateRequest extends BasicRequest
{
    public function __construct($config, $sku, $num)
    {
        parent::__construct($config);
        $this->init($sku, $num);
    }

    public function init($sku, $num)
    {
        $this->method = "PUT";
        $this->url = "https://marketplace.walmartapis.com/v3/inventory";

        $this->query = ["sku" => $sku];
        $this->body = json_encode([
            "sku" => $sku,
            "quantity" => [
                "unit" => "EACH",
                "amount" => $num
            ]
        ]);
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

}
