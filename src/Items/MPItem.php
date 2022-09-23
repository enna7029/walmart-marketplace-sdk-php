<?php

namespace Walmart\Items;

class MPItem extends ItemInit
{
    /**
     * @param $specs
     * @param $required
     * @param $itemsField
     * @param $params
     * @throws \Exception
     */
    public function __construct($specs, $required, $itemsField, $params)
    {
        $this->specs = $specs;
        $this->required = $required;
        $this->itemsField = $itemsField;
        $this->params = $params;

        $this->getOrderable();
        $this->getVisible();
    }

    /**
     * @return void
     * @throws \Exception
     */
    protected function getOrderable()
    {
        if (!isset($this->params['Orderable']))
            throw new \Exception("MPItem >> Orderable is required.");
        $this->Orderable = new Orderable(
            $this->specs["MPItemFeed"]["MPItem"]["Orderable"],
            $this->required['Orderable'],
            $this->itemsField,
            $this->params['Orderable']
        );
    }

    /**
     * @return void
     * @throws \Exception
     */
    protected function getVisible()
    {
        if (!isset($this->params['Visible']))
            throw new \Exception("MPItem >> Visible is required.");

        $category = implode(array_keys($this->params['Visible']));
        $this->Visible = new Visible();
        $this->Visible->$category = new class(
            $this->specs["MPItemFeed"]["MPItem"]["Visible"][$category],
            $this->required[$category],
            $this->itemsField,
            $this->params['Visible'][$category]
        ) extends ItemInit {
            public function __construct($specs, $required, $itemsField, $params)
            {
                $this->specs = $specs;
                $this->required = $required;
                $this->itemsField = $itemsField;
                $this->params = $params;
                $this->Init();
            }
        };
    }
}
