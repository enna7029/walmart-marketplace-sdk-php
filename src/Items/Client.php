<?php

namespace Walmart\Items;

use Walmart\Configs\Config;
use Walmart\Requests\BulkItemSetupRequest;
use Walmart\Requests\GetAnItemRequest;
use Walmart\Requests\ItemSearchRequest;
use Walmart\Requests\RetireAnItemRequest;
use Walmart\Requests\ItemAssociationsRequest;

class Client
{
    protected string $MPItemSpecFilePath = "./vendor/dogfoodingcn/walmart-marketplace-sdk-php/src/MP_ITEM_SPEC_4.4.json";

    protected array $specs;

    protected array $required;

    protected array $itemsField;

    public function __construct()
    {
        if (PHP_SAPI !== 'cli') {
            $this->MPItemSpecFilePath = "../vendor/dogfoodingcn/walmart-marketplace-sdk-php/src/MP_ITEM_SPEC_4.4.json";
        }
        $this->specInit();

    }

    /**
     * @return void
     * @throws \Exception
     */
    protected function specInit()
    {
        if (!file_exists($this->MPItemSpecFilePath) || !($specs = file_get_contents($this->MPItemSpecFilePath)))
            throw new \Exception("MP_ITEM_SPEC_4.4.json not exists");
        $specs = json_decode($specs, true);
        $this->itemsField = [];
        $this->specs = $this->parseConfigs($specs);
    }

    /**
     * @param $specs
     * @param int $level
     * @return array
     */
    protected function parseConfigs($specs, int $level = 0): array
    {
        $res = [];

        if ($level == 0) {
            if (isset($specs['properties'])) {
                isset($specs['required']) && $this->required[$specs['title']] = $specs['required'];
                $res[$specs['title']] = $this->parseConfigs($specs['properties'], ++$level);
            }
            return $res;
        }

        foreach ($specs as $name => $item) {
            isset($item['required']) && $this->required[$name] = $item['required'];
            isset($item['items']) && !in_array($name, $this->itemsField) && $this->itemsField[] = $name;

            if (isset($item['properties'])) {
                $res[$name] = $this->parseConfigs($item['properties'], ++$level);
            } elseif (isset($item['items']['properties'])) {
                $res[$name] = $this->parseConfigs($item['items']['properties'], ++$level);
            } else {
                $res[$name] = $item;
            }
        }

        return $res;

    }

    /**
     * @return array
     */
    public function getSpecs()
    {
        return $this->specs;
    }

    /**
     * @return array
     */
    public function getRequired()
    {
        return $this->required;
    }

    /**
     * @return array
     */
    public function getItemsField()
    {
        return $this->itemsField;
    }

    /**
     * @param $params
     * @return MPItemFeedHeader
     */
    public function MPItemFeedHeaderInit($params)
    {
        return (new MPItemFeedHeader($this->specs, $this->required, $this->itemsField, $params));
    }

    /**
     * @param $params
     * @return MPItem
     */
    public function MPItemInit($params)
    {
        return (new MPItem($this->specs, $this->required, $this->itemsField, $params));
    }

    /**
     * @return void
     */
    public function BulkItemSetup($config, $requestParams)
    {
        $request = new BulkItemSetupRequest($config, $requestParams);
        return $request->sendRequest()->parseResponse()->getFeedId();
    }

    public function GetAnItem($config, $sku)
    {
        $request = new GetAnItemRequest($config, $sku);
        return $request->sendRequest()->parseResponse();
    }

    public function ItemSearch($config, $requestParams)
    {
        $request = new ItemSearchRequest($config, $requestParams);
        return $request->sendRequest()->parseResponse();
    }

    public function RetireAnItem($config, $sku)
    {
        $request = new RetireAnItemRequest($config, $sku);
        return $request->sendRequest()->parseResponse();
    }

    public function ItemAssociations($config, $items)
    {
        $request = new ItemAssociationsRequest($config, $items);
        return $request->sendRequest()->parseResponse();
    }

}
