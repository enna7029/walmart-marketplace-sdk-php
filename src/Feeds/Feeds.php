<?php

namespace Walmart\Feeds;

use Walmart\Requests\FeedItemStatusRequest;

class Feeds
{
    public function getStatusWithDetail($config, $feedID)
    {
        $request = new FeedItemStatusRequest($config, $feedID);
        return $request->sendRequest()->parseResponse();
    }
}
