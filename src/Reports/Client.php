<?php

namespace Walmart\Reports;

use Walmart\Configs\Config;
use Walmart\Requests\ReportRequest;

class Client
{
    public function GetReport(Config $config, string $type)
    {
        $requestParams = ['type' => $type];
        $request = new ReportRequest($config, $requestParams);
        return $request->sendRequest()->parseResponse();
    }
}
