<?php
namespace SkypeBot\Command;

use SkypeBot\Api\Api;
use SkypeBot\Config;
use SkypeBot\DataProvider\TokenProvider;
use SkypeBot\Entity\AccessToken;
use SkypeBot\SkypeBot;

class Authenticate extends Command {

    protected $appId;
    protected $appSecret;
    protected $authenticateEndpoint;

    public function __construct() {
        $config = SkypeBot::getInstance()->getConfig();
        $this->appId = $config->getAppId();
        $this->appSecret = $config->getAppSecret();
        $this->authenticateEndpoint = $config->getAuthEndpoint();
    }

    /**
     * @return Api
     */
    public function getApi()
    {
        return new Api(
            $this->authenticateEndpoint,
            array (
                Api::PARAM_PARAMS => array(
                    'grant_type' => 'client_credentials',
                    'scope' => 'https://graph.microsoft.com/.default',
                    'client_id' => $this->appId,
                    'client_secret' => $this->appSecret
                ),
                Api::PARAM_HEADERS => array(
                    'Content-Type: application/x-www-form-urlencoded'
                )
            )
        );
    }

    public function processResult($result)
    {
        SkypeBot::getInstance()->getTokenProvider()->saveToken(new AccessToken($result));
    }
}