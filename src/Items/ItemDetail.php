<?php

namespace Walmart\Items;

class ItemDetail
{
    public string $itemId;
    public string $isMarketPlaceItem;
    public array $images;
    public string $freeShipping;
    public string $offerCount;
    public array $price;
    public string $description;
    public string $title;
    public string $brand;
    public string $productType;

    public function __construct($params)
    {
        $this->itemId = $params['itemId'] ?? '';
        $this->isMarketPlaceItem = $params['isMarketPlaceItem'] ?? '';
        $this->images = $params['images'] ?? [];
        $this->freeShipping = $params['freeShipping'] ?? '';
        $this->offerCount = $params['offerCount'] ?? '';
        $this->price = $params['price'] ?? [];
        $this->description = $params['description'] ?? '';
        $this->title = $params['title'] ?? '';
        $this->brand = $params['brand'] ?? '';
        $this->productType = $params['productType'] ?? '';
    }
}
