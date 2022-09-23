<?php

namespace Walmart\Configs;


class Config
{
    public string $svcName;

    public string $clientID;

    public string $clientSecret;


    /**
     * @param $svcName
     * @param $clientID
     * @param $clientSecret
     * @return $this
     * @throws \Exception
     */
    public function Init($svcName, $clientID, $clientSecret)
    {
        if (empty($svcName) || empty($clientID) || empty($clientSecret))
            throw new \Exception("auth message not complete");

        $this->svcName = $svcName;
        $this->clientID = $clientID;
        $this->clientSecret = $clientSecret;

        return $this;
    }

    


}

