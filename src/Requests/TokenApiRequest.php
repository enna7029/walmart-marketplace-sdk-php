<?php

namespace Walmart\Requests;

use Walmart\Configs\Config;
use Walmart\Facades\Xml;
use Walmart\Responses\TokenApiResponse;

class TokenApiRequest extends BasicRequest
{

    protected $url = "";

    public function __construct(Config $config)
    {
        parent::__construct($config);
        $this->init();
    }

    public function init()
    {
        $this->method = "POST";
        $this->url = "https://marketplace.walmartapis.com/v3/token";
        $this->body = ["grant_type" => "client_credentials"];
        $this->bodyType = "x-www-form-urlencoded";
    }

    public function initHeader()
    {
        $this->header = [
            "Authorization" => $this->getAuthorization(),
            "WM_QOS.CORRELATION_ID" => $this->getCorrelationId(),
            "WM_SVC.NAME" => $this->config->svcName,
            "Content-Type" => "application/x-www-form-urlencoded"
        ];
    }

    public function sendRequest()
    {
        parent::sendRequest();
        return $this;
    }

    public function parseResponse()
    {
        $this->responseData = Xml::toArray($this->response);
        return new TokenApiResponse($this->responseData);
    }

}
