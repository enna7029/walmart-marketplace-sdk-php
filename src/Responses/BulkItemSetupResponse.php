<?php

namespace Walmart\Responses;

class BulkItemSetupResponse
{
    protected $feedId;

    public function __construct($params)
    {
        if (!isset($params["feedId"]))
            throw new \Exception(json_encode($params));
        $this->feedId = $params["feedId"];
    }

    public function getFeedId(){
        return $this->feedId;
    }
}
