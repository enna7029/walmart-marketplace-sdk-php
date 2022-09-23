<?php

namespace Walmart\Requests;

use Walmart\Facades\Auth;
use Walmart\Facades\Xml;
use Walmart\Responses\BulkItemSetupResponse;
use Walmart\Responses\TokenApiResponse;

class BulkItemSetupRequest extends BasicRequest
{
    public function __construct($config, $requestParams)
    {
        parent::__construct($config);
        $this->init($requestParams);
    }

    public function init($requestParams)
    {
        $this->method = "POST";
        $this->url = "https://marketplace.walmartapis.com/v3/feeds";

        $this->query = ['feedType' => 'MP_ITEM'];
        $this->bodyType = "file";
        $this->body = $this->getBody($requestParams);
    }

    public function sendRequest()
    {
        parent::sendRequest();
        return $this;
    }

    public function parseResponse()
    {
        $this->responseData = Xml::toArray($this->response, true, 'ns2');
        return new BulkItemSetupResponse($this->responseData);
    }

    public function getBody($requestParams)
    {
        $json = json_encode($requestParams);
        $path = sys_get_temp_dir() . DIRECTORY_SEPARATOR . "Feeds";

        if (!is_dir($path)) {
            mkdir($path);
        }
        $fileName = "Feed_" . date("YmdHis") . "_" . rand(10000, 99999) . ".json";
        $fp = fopen($path . DIRECTORY_SEPARATOR . $fileName, 'c+');
        fwrite($fp, $json);
        fclose($fp);
        return $path . DIRECTORY_SEPARATOR . $fileName;
    }

}
