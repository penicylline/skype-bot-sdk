<?php

namespace SkypeBot;

class Config
{
    private $appId;
    private $appSecret;
    private $authEndpoint = 'https://login.microsoftonline.com/common/oauth2/v2.0/token';
    private $apiEndpoint = 'https://apis.skype.com';
    private $openIdEndpoint = 'https://api.aps.skype.com';

    /**
     * Config constructor.
     * @param string $appId
     * @param string $appSecret
     * @param string $authEndpoint
     * @param string $apiEndpoint
     * @param string $openIdEndpoint
     */
    public function  __construct($appId, $appSecret, $apiEndpoint = null, $authEndpoint = null, $openIdEndpoint = null)
    {
        $this->appId = $appId;
        $this->appSecret = $appSecret;
        if ($authEndpoint) {
            $this->authEndpoint = $authEndpoint;
        }
        if ($apiEndpoint) {
            $this->apiEndpoint = $apiEndpoint;
        }
        if ($openIdEndpoint) {
            $this->openIdEndpoint = $openIdEndpoint;
        }
    }

    public function getAppId()
    {
        return $this->appId;
    }

    public function getAppSecret()
    {
        return $this->appSecret;
    }

    public function getAuthEndpoint()
    {
        return $this->authEndpoint;
    }

    public function getApiEndpoint()
    {
        return $this->apiEndpoint;
    }

    public function getOpenIdEndpoint()
    {
        return $this->openIdEndpoint;
    }
}