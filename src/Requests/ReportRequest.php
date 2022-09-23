<?php

namespace Walmart\Requests;

use Walmart\Facades\Auth;

class ReportRequest extends BasicRequest
{
    public function __construct($config, $requestParams)
    {
        parent::__construct($config);
        $this->init($requestParams);
    }

    public function init($requestParams)
    {
        $this->method = "GET";
        $this->url = "https://marketplace.walmartapis.com/v3/getReport";
        $this->bodyType = "none";
        $this->query = ['type' => $requestParams['type']];
    }

    public function sendRequest()
    {
        parent::sendRequest();
        return $this;
    }

    public function parseResponse()
    {
        $path = sys_get_temp_dir() . DIRECTORY_SEPARATOR . "Reports";
        if (!is_dir($path)) {
            mkdir($path);
        }
        $fileName = "Report_" . date("YmdHis") . "_" . rand(10000, 99999);
        $ext = ".zip";
        $fp = fopen($path . DIRECTORY_SEPARATOR . $fileName . $ext, 'w+');
        fwrite($fp, $this->response);
        fclose($fp);


        $zip = new \ZipArchive;
        $zip->open($path . DIRECTORY_SEPARATOR . $fileName . $ext);
        $zip->extractTo($path . DIRECTORY_SEPARATOR . $fileName);
        $zip->close();

        $list = scandir($path . DIRECTORY_SEPARATOR . $fileName);
        $this->responseData = [];
        foreach ($list as $v) {
            if (is_file($path . DIRECTORY_SEPARATOR . $fileName . DIRECTORY_SEPARATOR . $v)) {
                $this->responseData[$v] = $path . DIRECTORY_SEPARATOR . $fileName . DIRECTORY_SEPARATOR . $v;
            }
        }
        return $this->responseData;
    }


}
