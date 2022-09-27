<?php

namespace Walmart\Requests;

class DownloadReportRequest extends BasicRequest
{
    public function __construct($config, $request_id)
    {
        parent::__construct($config);
        $this->init($request_id);
    }

    public function init($request_id)
    {
        $this->method = "GET";
        $this->url = "https://marketplace.walmartapis.com/v3/reports/downloadReport";
        $this->query = [
            'requestId' => $request_id,
        ];
        $this->body = [];
        $this->bodyType = "none";
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