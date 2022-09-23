<?php

namespace Walmart\Authentication;

use Walmart\Configs\Config;
use Walmart\Requests\TokenApiRequest;

class Auth
{
    public function getAccessToken(Config $config)
    {
        $request = new TokenApiRequest($config);
        return $request->sendRequest()->parseResponse()->getAccessToken();
    }
}
