<?php

namespace Walmart\Items;

class ItemInit
{
    protected array $specs;

    protected array $required;

    protected array $itemsField;

    protected array $params;

    /**
     * @return void
     * @throws \Exception
     */
    public function Init()
    {
        foreach ($this->specs as $key => $value) {
            if (!$this->validateSpec($key, $value))
                continue;
            if (in_array($key, $this->itemsField)) {
                is_array($this->params[$key]) ? $this->$key = $this->params[$key] : $this->$key[] = $this->params[$key];
            } else {
                $this->$key = $this->params[$key];
            }
        }
    }

    /**
     * @param $specName
     * @param $specs
     * @return bool
     * @throws \Exception
     */
    public function validateSpec($specName, $specs)
    {
        $classInfo = explode('\\', get_called_class());
        $className = end($classInfo);
        // 必填、无值：异常
        if (in_array($specName, $this->required)) {
            if (!isset($this->params[$specName]))
                throw new \Exception("$className >> $specName is required.");
        }
        // 无值：返回false
        if (!isset($this->params[$specName]))
            return false;

        // 有值：做校验
        // 单个输入值
        if (isset($specs["type"])) {
            $this->validateSingleSpec($className, $specName, $specs, $this->params[$specName]);
        }
        // 组合输入框
        if (!isset($specs["type"])) {
            // 数组
            if(in_array($specName, $this->itemsField)) {
                foreach ($this->params[$specName] as $key => $item) {
                    foreach ($specs as $k => $v) {
                        if (!isset($this->params[$specName][$key][$k]))
                            throw new \Exception(
                                "$className  >> $specName >> $key >> $k is not exist. "
                            );
                        $this->validateSingleSpec($className, $k, $v, $this->params[$specName][$key][$k], $specName);
                    }
                }
            } else {
                // 非数组
                foreach ($specs as $k => $v) {
                    if (!isset($this->params[$specName][$k]))
                        throw new \Exception(
                            "$className  >> $specName >> $k is not exist. "
                        );
                    $this->validateSingleSpec($className, $k, $v, $this->params[$specName][$k], $specName);
                }
            }
        }

        return true;
    }

    /**
     * @param $className
     * @param $specName
     * @param $specs
     * @param $input
     * @param $parentSpec
     * @return void
     * @throws \Exception
     */
    public function validateSingleSpec($className, $specName, $specs, &$input, $parentSpec = '')
    {
        $specsString = $specName;
        $parentSpec && $specsString .= " >> $parentSpec";

        if ($specs["type"] == "string"
            && isset($specs['enum'])
            && !in_array($input, $specs['enum'])) {
            throw new \Exception(
                "$className  >> $specsString is not in enum "
                . implode(",", $specs['enum'])
            );
        }

        if ($specs["type"] == "number" || $specs["type"] == "integer") {
            if (isset($specs["minimum"]) && $input < $specs["minimum"])
                throw new \Exception(
                    "$className  >> $specsString:$input < minimum:"
                    . $specs["minimum"]
                );

            if (isset($specs["exclusiveMaximum"], $specs["maximum"])) {
                if ($specs["exclusiveMaximum"] && $specs["maximum"] < $input)
                    throw new \Exception(
                        "$className  >> $specsString:$input > maximum:"
                        . $specs["maximum"]
                    );
            }

            if ($specs["type"] == "integer" && !is_int($input)) {
                throw new \Exception(
                    "$className  >> $specsString must be int $input given."
                );
            }

            if ($specs["type"] == "number"){
                $input = (float)$input;
            }

            if($specs["type"] == "integer") {
                $input = (int)$input;
            }
        }

        if ($specs["type"] == "array") {
            if (!is_array($input)
                || (isset($specs["minItems"])
                    && $specs["minItems"] > count($input)
                )
            ) {
                throw new \Exception(
                    "$className  >> $specsString is not array or minItems < " . $specs["minItems"]
                );
            }
        }
    }
}
