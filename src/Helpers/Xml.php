<?php

namespace Walmart\Helpers;

class Xml
{
    public function toArray($xml, bool $is_prefix = false, string $namespace_or_prefix = "", int $options = 0)
    {
        $res = simplexml_load_string($xml, 'SimpleXMLElement', $options, $namespace_or_prefix, $is_prefix);
        return json_decode(json_encode($res), true);
    }

    public function toArray1($xml, bool $is_prefix = false, string $namespace_or_prefix = "", int $options = 0)
    {
        $res = simplexml_load_string($xml, 'SimpleXMLElement', $options, $namespace_or_prefix, $is_prefix);
        return json_decode(json_encode($res), true);
    }
}
