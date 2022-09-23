<?php

namespace Walmart\Items;

class MPItemFeedHeader extends ItemInit
{

    public function __construct($specs, $required, $itemsField, $params)
    {
        $this->specs = $specs['MPItemFeed']['MPItemFeedHeader'];
        $this->required = $required['MPItemFeedHeader'];
        $this->itemsField = $itemsField;
        $this->params = $params;
        $this->Init();
    }
}
