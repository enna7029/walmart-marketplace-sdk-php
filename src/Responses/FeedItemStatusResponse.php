<?php

namespace Walmart\Responses;

use Walmart\Feeds\FeedItemDetails;

class FeedItemStatusResponse
{
    protected string $feedId;

    protected string $feedStatus;

    protected mixed $ingestionErrors = NULL;

    protected int $itemsReceived;

    protected int $itemsSucceeded;

    protected int $itemsFailed;

    protected int $itemsProcessing;

    public function __construct($params)
    {
        if (isset($params['feedId']))
            $this->feedId = $params['feedId'];
        if (isset($params['feedStatus']))
            $this->feedStatus = $params['feedStatus'];
        if (isset($params['ingestionErrors']))
            $this->ingestionErrors = $params['ingestionErrors'];
        if (isset($params['itemsReceived']))
            $this->itemsReceived = $params['itemsReceived'];
        if (isset($params['itemsSucceeded']))
            $this->itemsSucceeded = $params['itemsSucceeded'];
        if (isset($params['itemsFailed']))
            $this->itemsFailed = $params['itemsFailed'];
        if (isset($params['itemsProcessing']))
            $this->itemsProcessing = $params['itemsProcessing'];
        if (isset($params['itemDetails']['itemIngestionStatus'])) {
            foreach ($params['itemDetails']['itemIngestionStatus'] as $item) {
                $this->itemDetails[] = new FeedItemDetails($item);
            }
        }

    }

    public function getFeedStatus()
    {
        return $this->feedStatus;
    }

    public function getItemDetails()
    {
        return $this->itemDetails;
    }

    public function getIngestionErrors()
    {
        return $this->ingestionErrors;
    }
}
