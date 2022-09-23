<?php

namespace Walmart\Requests;

use Walmart\Responses\FeedItemStatusResponse;

class FeedItemStatusRequest extends BasicRequest
{
    public function __construct($config, $feedID)
    {
        parent::__construct($config);
        $this->init($feedID);
    }

    public function init($feedID)
    {
        $this->method = "GET";
        $this->url = "https://marketplace.walmartapis.com/v3/feeds/".$feedID;
        $this->query = ["includeDetails" => 'true'];
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
//        $this->debug = 1;
        parent::sendRequest();
        return $this;
    }

    public function parseResponse()
    {
        $this->responseData = json_decode($this->response, true);
        return new FeedItemStatusResponse($this->responseData);
    }


}
