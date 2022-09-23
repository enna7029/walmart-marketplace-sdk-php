<?php

namespace Walmart\Inventory;

use Walmart\Requests\InventoryUpdateRequest;

class Inventory
{
    public function update($config, $sku, $num)
    {
        $request = new InventoryUpdateRequest($config, $sku, $num);
        return $request->sendRequest()->parseResponse();
    }
}
