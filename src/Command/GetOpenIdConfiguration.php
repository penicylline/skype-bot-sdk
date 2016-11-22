<?php
namespace SkypeBot\Command;

use SkypeBot\Api\Api;
use SkypeBot\Api\HttpClient;
use SkypeBot\DataProvider\OpenIdConfigProvider;
use SkypeBot\Entity\OpenIdConfig;
use SkypeBot\SkypeBot;

class GetOpenIdConfiguration extends Command {

    /**
     * @return Api
     */
    public function getApi()
    {
        return new Api(
            SkypeBot::getInstance()->getConfig()->getOpenIdEndpoint() . '/v1/.well-known/openidconfiguration',
            array(
                Api::PARAM_JSON_RESPONSE => true,
                APi::PARAM_METHOD => HttpClient::METHOD_GET
            )
        );
    }

    public function processResult($result)
    {
        if (!$result) {
            return;
        }
        $configEntity = new OpenIdConfig($result, true);
        SkypeBot::getInstance()->getOpenIdConfigProvider()->saveConfig($configEntity);
    }
}