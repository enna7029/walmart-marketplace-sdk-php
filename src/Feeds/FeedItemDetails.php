<?php

namespace Walmart\Feeds;

class FeedItemDetails
{
    public string $sku;


    public function __construct($params)
    {
        $this->sku = $params['sku'];
        $this->wpid = $params['wpid'];
        $this->itemid = $params['itemid'];
        $this->ingestionStatus = $params['ingestionStatus'];
        $this->ingestionErrors = $params['ingestionErrors'];
        $this->additionalAttributes = $params['additionalAttributes'];
        if(isset($params['productIdentifiers']["productIdentifier"])) {
            foreach ($params['productIdentifiers']["productIdentifier"] as $identifier )
                $this->productIdentifiers = $identifier;
        }
    }
}
