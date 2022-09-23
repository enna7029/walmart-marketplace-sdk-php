<?php

namespace Walmart\Responses;

class ItemResponse
{
    public function __construct($params)
    {
        $this->mart = $params["mart"] ?? '';
        $this->sku = $params["sku"] ?? '';
        $this->wpid = $params["wpid"] ?? '';
        $this->upc = $params["upc"] ?? '';
        $this->gtin = $params["gtin"] ?? '';
        $this->productName = $params["productName"] ?? '';
        $this->shelf = $params["shelf"] ?? '';
        $this->productType = $params["productType"] ?? '';
        $this->price = [
            "amount" =>  $params["price"]["amount"],
            "currency" =>  $params["price"]["currency"],
        ];
        $this->publishedStatus = $params["publishedStatus"] ?? '';
        $this->additionalAttributes = $params["additionalAttributes"] ?? '';
        $this->unpublishedReasons = $params["unpublishedReasons"]["reason"] ?? '';
        $this->lifecycleStatus = $params["lifecycleStatus"] ?? '';
        $this->variantGroupId = $params["variantGroupId"] ?? '';
        $this->variantGroupInfo = $params["variantGroupInfo"] ?? '';
    }
}
