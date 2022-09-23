<?php

namespace Walmart\Requests;

use Walmart\Items\ItemDetail;

class ItemSearchRequest extends BasicRequest
{
    public function __construct($config, $query)
    {
        parent::__construct($config);
        $this->init($query);
    }

    public function init($query)
    {
        $this->method = "GET";
        $this->url = "https://marketplace.walmartapis.com/v3/items/walmart/search";
        $this->query = $query;
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
        $this->response = json_decode($this->response, true);
        if (isset($this->response['items'])) {
            foreach ($this->response['items'] as $detail) {
                $this->responseData[$detail["itemId"]] = new ItemDetail($detail);
            }
        } else {
            $this->responseData = [];
        }
        return $this->responseData;
    }
}
