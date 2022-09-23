<?php

namespace Walmart\Responses;

class TokenApiResponse
{
    protected $accessToken;
    protected $tokenType;
    protected $expiresIn;

    public function __construct($params)
    {
        if (!isset($params["accessToken"]))
            throw new \Exception("Get auth fail.");
        $this->accessToken = $params["accessToken"];
        $this->tokenType = $params["tokenType"];
        $this->expiresIn = $params["expiresIn"];
    }

    public function getAccessToken(){
        return $this->accessToken;
    }
}
