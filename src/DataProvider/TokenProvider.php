<?php
namespace SkypeBot\DataProvider;


use SkypeBot\Command\Authenticate;
use SkypeBot\Interfaces\DataStorage;
use SkypeBot\SkypeBot;
use SkypeBot\Entity\AccessToken;

class TokenProvider extends DataProvider
{
    const KEY_STORAGE = 'api_token';
    const KEY_TOKEN = 'token';
    const KEY_EXPIRED = 'expired';

    /**
     * @var DataStorage
     */
    protected $storage;

    /**
     * @var \SkypeBot\Config
     */
    protected $config;

    /**
     * @var AccessToken
     */
    private $token;

    /**
     * TokenProvider constructor.
     * @param DataStorage $dataStorage
     */
    public function __construct(DataStorage $dataStorage) {
        $this->config = SkypeBot::getInstance()->getConfig();
        $this->storage = $dataStorage;
    }

    /**
     * @return AccessToken
     */
    public function getAccessToken()
    {
        if (!$this->token) {
            $this->token = $this->storage->get(static::KEY_STORAGE);
        }

        if (!$this->token || $this->token->getExpiredTime() < time() - 60) {
            return $this->getNewToken();
        }

        return $this->token;
    }

    public function getNewToken()
    {
        $command = new Authenticate(
            $this->config->getAppId(),
            $this->config->getAppSecret(),
            $this
        );

        $this->getApiClient()->call($command);
        return $this->token;
    }

    public function saveToken(AccessToken $token)
    {
        $this->token = $token;
        $this->storage->set(
            static::KEY_STORAGE,
            $token
        );
    }

    public function clearToken()
    {
        $this->storage->remove(static::KEY_STORAGE);
    }
}