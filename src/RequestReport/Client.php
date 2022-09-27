<?php

namespace Walmart\RequestReport;

use Walmart\Configs\Config;
use Walmart\Requests\CreateReportRequest;
use Walmart\Requests\CheckReportRequest;
use Walmart\Requests\DownloadReportRequest;

class Client
{
    public function requestReport(Config $config, $params)
    {
        $request = new CreateReportRequest($config, $params);
        return $request->sendRequest()->parseResponse();
    }

    public function checkReport(Config $config, $request_id)
    {
        $request = new CheckReportRequest($config, $request_id);
        return $request->sendRequest()->parseResponse();
    }

    public function downloadReport(Config $config, $request_id)
    {
        $request = new DownloadReportRequest($config, $request_id);
        return $request->sendRequest()->parseResponse();
    }
}