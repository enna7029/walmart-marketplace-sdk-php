<?php

namespace Walmart\Requests;

class CreateReportRequest extends BasicRequest
{
    public function __construct($config, $requestParams)
    {
        parent::__construct($config);
        $this->init($requestParams);
    }

    public function init($requestParams)
    {
        $this->method = "POST";
        $this->url = "https://marketplace.walmartapis.com/v3/reports/reportRequests";
        $this->query = [
            'reportType' => $requestParams['reportType'],
            'reportVersion' => $requestParams['reportVersion']
        ];
        $this->body = $this->getBody($requestParams);
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

    protected function getBody($requestParams)
    {
        $body = [];

        if (isset($requestParams['rowFilters']) && !empty($requestParams['rowFilters'])) {
            if (!is_array($requestParams['rowFilters'])) {
                $rowFilters = json_decode($requestParams['rowFilters'], true);
            } else {
                $rowFilters = $requestParams['rowFilters'];
            }
            $body['rowFilters'] = $rowFilters;
        }
        if (isset($requestParams['excludeColumns']) && !empty($requestParams['excludeColumns'])) {
            if (!is_array($requestParams['excludeColumns'])) {
                $excludeColumns = json_decode($requestParams['excludeColumns'], true);
            } else {
                $excludeColumns = $requestParams['excludeColumns'];
            }
            $body['excludeColumns'] = $excludeColumns;
        }

        return json_encode($body);
    }
}