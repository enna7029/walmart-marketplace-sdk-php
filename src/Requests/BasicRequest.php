<?php

namespace Walmart\Requests;

use GuzzleHttp\Client;
use Walmart\Configs\Config;
use Walmart\Facades\Auth;

class BasicRequest
{
    protected $config;

    protected $method;

    protected $url;

    protected $header;

    protected $query;

    protected $body;

    protected $bodyType; //enum [none, form-data, x-www-form-urlencoded, raw]

    protected $requestData;

    protected $response;

    protected $responseData;

    protected $debug;

    public function __construct(Config $config)
    {
        $this->config = $config;
        $this->initHeader();
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function initHeader()
    {
        $this->header = [
            "Authorization" => $this->getAuthorization(),
            "WM_SEC.ACCESS_TOKEN" => Auth::getAccessToken($this->config),
            "WM_SVC.NAME" => $this->config->svcName,
            "WM_QOS.CORRELATION_ID" => $this->getCorrelationId(),
        ];
    }

    public function sendRequest()
    {
        $this->validateRequestParams();
        $this->getRequestData();

        $client = new Client([
            'verify' => false
        ]);
        if ($this->debug) {
            echo "<pre>";
            var_dump($this->method, $this->url, $this->requestData);
            die;
        }

        $response = $client->request($this->method, $this->url, $this->requestData);
        $this->response = $response->getBody()->getContents();
    }

    /**
     * @return void
     * @throws \Exception
     */
    public function validateRequestParams()
    {
        if (empty($this->method))
            throw new \Exception("Request type is required.");
        if (empty($this->url))
            throw new \Exception("Request url is required.");
    }

    public function getRequestData()
    {
        if (!empty($this->header))
            $this->requestData['headers'] = $this->header;
        if (!empty($this->query))
            $this->requestData['query'] = $this->query;
        if (empty($this->body))
            return;

        switch ($this->bodyType) {
            case "form-data":
                $this->requestData['multipart'] = $this->body;
                break;
            case "x-www-form-urlencoded":
                $this->requestData['form_params'] = $this->body;
                break;
            case "raw":
                $this->requestData['body'] = $this->body;
                break;
            case "file":
                $this->requestData['body'] = fopen($this->body, "r");
                break;
            default:
                break;
        }
    }

    /**
     * @param $clientID
     * @param $clientSecret
     * @return string
     */
    public function getAuthorization()
    {
        return "Basic " . base64_encode($this->config->clientID . ":" . $this->config->clientSecret);
    }

    /**
     * @return string
     */
    public function getCorrelationId()
    {
        if (function_exists('com_create_guid') === true) {
            return trim(com_create_guid(), '{}');
        }

        return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
    }

    /**
     * @return mixed|array
     */
    public function getHeader()
    {
        return $this->header;
    }

}
