<?php

namespace Walmart\Feeds;

class MPItemFeed
{

    protected $MPItemFeedHeader;

    protected $MPItem;

    public function __construct()
    {
        $this->MPItemFeedHeader = '111';
        $this->MPItem = [
            2222,
            3333,
        ];
    }
}
