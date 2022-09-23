<?php

namespace Walmart\Items;

class Orderable extends ItemInit
{
    public function __construct($specs, $required, $itemsField, $params)
    {
        $this->specs = $specs;
        $this->required = $required;
        $this->itemsField = $itemsField;
        $this->params = $params;
        $this->Init();
    }

}
