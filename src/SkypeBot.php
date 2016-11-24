<?php

namespace SkypeBot;

use SkypeBot\Api\ApiClient;
use SkypeBot\Api\HttpClient;
use SkypeBot\DataProvider\OpenIdConfigProvider;
use SkypeBot\DataProvider\OpenIdKeysProvider;
use SkypeBot\DataProvider\TokenProvider;
use SkypeBot\Interfaces\DataStorage;
use SkypeBot\Listener\Dispatcher;
use SkypeBot\Listener\Request;
use SkypeBot\Listener\Security;

class SkypeBot
{
    /**
     * @var SkypeBot
     */
    protected static $instance;

    protected $resolvedObjs;

    protected $rawObjs;

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
        $this->resolvedObjs = array();
        $this->rawObjs = array();
        $this->set('config', $config);
        $this->set('data_storage', $dataStorage);
        $this->initComponents($config, $dataStorage);
    }

    protected function initComponents(Config $config, DataStorage $dataStorage)
    {
        $this->set('api_client', function (){
            return ApiClient::getInstance();
        });
        $this->set('openid_config', function () use($dataStorage) {
            return new OpenIdConfigProvider($dataStorage);
        });
        $this->set('openid_keys', function () use($dataStorage) {
            return new OpenIdKeysProvider($dataStorage);
        });
        $this->set('token_provider', function() use($dataStorage) {
            return new TokenProvider($dataStorage);
        });
        $this->set('http_client', function() {
            return HttpClient::getInstance();
        });
        $this->set('security', function() {
            return new Security(SkypeBot::getInstance()->getOpenIdKeysProvider());
        });
        $this->set('dispatcher', function() {
            return new Dispatcher(SkypeBot::getInstance()->getSecurity());
        });
        $this->set('request', function() {
            return new Request();
        });
    }

    /**
     * @param Config $config
     * @param DataStorage $dataStorage
     * @return SkypeBot
     */
    public static function init(Config $config, DataStorage $dataStorage)
    {
        static::$instance = new SkypeBot($config, $dataStorage);
        return static::$instance;
    }

    /**
     * @return SkypeBot
     * @throws \Exception
     */
    public static function getInstance()
    {
        if (static::$instance === null) {
            throw new \Exception('SkypeBot not initialized.');
        }
        return static::$instance;
    }

    /**
     * @return Config
     */
    public function getConfig()
    {
        return $this->get('config');
    }

    /**
     * @return DataStorage
     */
    public function getDataStorage()
    {
        return $this->get('data_storage');
    }

    /**
     * @return ApiClient
     */
    public function getApiClient()
    {
        return $this->get('api_client');
    }

    /**
     * @return OpenIdConfigProvider
     */
    public function getOpenIdConfigProvider()
    {
        return $this->get('openid_config');
    }

    /**
     * @return OpenIdKeysProvider
     */
    public function getOpenIdKeysProvider()
    {
        return $this->get('openid_keys');
    }

    /**
     * @return TokenProvider
     */
    public function getTokenProvider()
    {
        return $this->get('token_provider');
    }

    /**
     * @return HttpClient
     */
    public function getHttpClient()
    {
        return $this->get('http_client');
    }

    /**
     * @return Security
     */
    public function getSecurity()
    {
        return $this->get('security');
    }

    /**
     * @return Dispatcher
     */
    public function getNotificationListener()
    {
        return $this->get('dispatcher');
    }

    /**
     * @return Request
     */
    public function getRequest()
    {
        return $this->get('request');
    }

    /**
     * @param $key
     * @param $value
     * @return $this
     */
    public function set($key, $value)
    {
        $this->rawObjs[$key] = $value;
        unset($this->resolvedObjs[$key]);
        return $this;
    }

    /**
     * @param $key
     * @return mixed
     */
    public function get($key)
    {
        return $this->fetch($key);
    }

    /**
     * @param $key
     * @return mixed|void
     */
    protected function resolve($key)
    {
        if (!isset($this->rawObjs[$key])) {
            return;
        }
        if (is_callable($this->rawObjs[$key])) {
            return call_user_func($this->rawObjs[$key]);
        }
        return $this->rawObjs[$key];
    }

    /**
     * @param $key
     * @return mixed
     */
    protected function fetch($key)
    {
        if (!isset($this->resolvedObj[$key])) {
            $this->resolvedObj[$key] = $this->resolve($key);
        }
        return $this->resolvedObj[$key];
    }


}