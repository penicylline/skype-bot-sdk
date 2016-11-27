<?php
namespace SkypeBot\DataProvider;

use SkypeBot\Entity\Jwk\OpenIdConfig;
use SkypeBot\Interfaces\DataStorage;

class OpenIdConfigProvider extends DataProvider
{
    const KEY_STORAGE = 'openid_config';

    /**
     * @var DataStorage
     */
    protected $storage;

    private $config;

    /**
     * OpenIdConfigProvider constructor.
     * @param DataStorage $storage
     */
    public function __construct(DataStorage $storage) {
        $this->storage = $storage;
    }

    /**
     * @param $config
     */
    public function saveConfig($config) {
        $this->config = $config;
        $this->storage->set(static::KEY_STORAGE, $config);
        return $this;
    }

    /**
     * @return OpenIdConfig
     */
    public function getConfig() {
        if ($this->config === null) {
            $this->config = $this->storage->get(static::KEY_STORAGE);
        }
        if ($this->config === null) {
            $api = new \SkypeBot\Command\GetOpenIdConfiguration($this);
            $this->getApiClient()->call($api);
            $this->config = $this->storage->get(static::KEY_STORAGE);
        }
        return $this->config;
    }
}