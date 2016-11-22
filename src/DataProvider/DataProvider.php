<?php

namespace SkypeBot\DataProvider;

use SkypeBot\Api\ApiClient;
use SkypeBot\SkypeBot;

abstract class DataProvider
{
    protected $apiClient;

    /**
     * @param ApiClient $client
     */
    public function setApiClient(ApiClient $client)
    {
        $this->apiClient = $client;
    }

    /**
     * @return ApiClient
     */
    protected function getApiClient()
    {
        if ($this->apiClient === null) {
            $this->apiClient = SkypeBot::getInstance()->getApiClient();
        }
        return $this->apiClient;
    }
}