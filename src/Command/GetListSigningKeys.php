<?php
namespace SkypeBot\Command;

use SkypeBot\Api\Api;
use SkypeBot\Api\HttpClient;
use SkypeBot\DataProvider\OpenIdKeysProvider;
use SkypeBot\Entity\Jwk\JsonWebKey;
use SkypeBot\Exception\PayloadException;
use SkypeBot\SkypeBot;

class GetListSigningKeys extends AnonymousCommand
{

    private $endpoint;

    public function __construct($endpoint)
    {
        $this->endpoint = $endpoint;
    }

    /**
     * @return Api
     */
    public function getApi()
    {
        return new Api(
            $this->endpoint,
            [
                Api::PARAM_JSON_REQUEST => true,
                Api::PARAM_METHOD => HttpClient::METHOD_GET
            ]
        );
    }

    public function processResult($result)
    {
        if (!property_exists($result, 'keys') || !is_array($result->keys)) {
            throw new PayloadException('Signing keys should be an array');
        }
        $keys = array();
        foreach ($result->keys as $obj) {
            $key = new JsonWebKey($obj);
            $keys[$key->getKeyId()] = $key;
        }
        SkypeBot::getInstance()->getOpenIdKeysProvider()->saveKeys($keys);
    }
}