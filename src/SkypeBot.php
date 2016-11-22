<?php

namespace SkypeBot;

use SkypeBot\Api\ApiClient;
use SkypeBot\Api\HttpClient;
use SkypeBot\DataProvider\OpenIdConfigProvider;
use SkypeBot\DataProvider\OpenIdKeysProvider;
use SkypeBot\DataProvider\TokenProvider;
use SkypeBot\Interfaces\DataStorage;
use SkypeBot\Listener\Dispatcher;
use SkypeBot\Listener\Security;

class SkypeBot
{
    /**
     * @var SkypeBot
     */
    protected static $instance;

    /**
     * @var Config
     */
    protected $config;

    /**
     * @var DataStorage
     */
    protected $dataStorage;

    /**
     * @var ApiClient
     */
    protected $apiClient;

    /**
     * @var Dispatcher
     */
    protected $notificationListener;

    /**
     * @var OpenIdKeysProvider
     */
    protected $openIdKeysProvider;

    /**
     * @var OpenIdConfigProvider
     */
    protected $openIdConfigProvider;

    /**
     * @var HttpClient
     */
    protected $httpClient;

    /**
     * @var TokenProvider
     */
    protected $tokenProvider;

    private function __construct(Config $config, DataStorage $dataStorage)
    {
        $this->config = $config;
        $this->dataStorage = $dataStorage;
    }

    /**
     * @param Config $config
     * @param DataStorage $dataStorage
     * @return SkypeBot
     */
    public static function init(Config $config, DataStorage $dataStorage)
    {
        if (static::$instance === null) {
            static::$instance = new SkypeBot($config, $dataStorage);
        }
        return static::$instance;
    }

    /**
     * @return SkypeBot
     * @throws \Exception
     */
    public static function getInstance()
    {
        if (static::$instance === null) {
            throw new \Exception('');
        }
        return static::$instance;
    }

    /**
     * @return Config
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @return DataStorage
     */
    public function getDataStorage()
    {
        return $this->dataStorage;
    }

    /**
     * @return ApiClient
     */
    public function getApiClient()
    {
        if ($this->apiClient === null) {
            $this->apiClient = ApiClient::getInstance();
        }
        return $this->apiClient;
    }

    /**
     * @return OpenIdConfigProvider
     */
    public function getOpenIdConfigProvider()
    {
        if ($this->openIdConfigProvider === null) {
            $this->openIdConfigProvider = new OpenIdConfigProvider($this->getDataStorage());
        }
        return $this->openIdConfigProvider;
    }

    /**
     * @return OpenIdKeysProvider
     */
    public function getOpenIdKeysProvider()
    {
        if ($this->openIdKeysProvider === null) {
            $this->openIdKeysProvider = new OpenIdKeysProvider($this->getDataStorage());
        }
        return $this->openIdKeysProvider;
    }

    /**
     * @return TokenProvider
     */
    public function getTokenProvider()
    {
        if ($this->tokenProvider === null) {
            $this->tokenProvider = new TokenProvider($this->getDataStorage());
        }
        return $this->tokenProvider;
    }

    /**
     * @return HttpClient
     */
    public function getHttpClient()
    {
        if ($this->httpClient === null) {
            $this->httpClient = HttpClient::getInstance();
        }
        return $this->httpClient;
    }

    /**
     * @return Dispatcher
     */
    public function getNotificationListener()
    {
        if ($this->notificationListener === null) {
            $security = new Security($this->getOpenIdKeysProvider());
            $this->notificationListener = new Dispatcher($security);
        }
        return $this->notificationListener;
    }

    public function set($property, $value)
    {
        if (property_exists($this, $property)) {
            $this->{$property} = $value;
        }
        return $this;
    }
}