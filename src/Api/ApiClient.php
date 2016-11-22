<?php
namespace SkypeBot\Api;

use SkypeBot\Command\Authenticate;
use SkypeBot\Command\Command;
use SkypeBot\DataProvider\TokenProvider;
use SkypeBot\Exception\ResponseException;
use SkypeBot\Exception\SecurityException;
use SkypeBot\Interfaces\ApiLogger;
use SkypeBot\SkypeBot;
use SkypeBot\Storage\TokenStorage;

class ApiClient {

    /**
     * @var ApiClient
     */
    static private $instance;

    private $httpClient;

    /**
     * @var TokenProvider
     */
    private $tokenProvider;

    private function __construct()
    {

    }

    /**
     * @return Client
     * @throws \Exception
     */
    public static function getInstance()
    {
        if (static::$instance === null) {
            static::$instance = new ApiClient();
        }
        return static::$instance;
    }

    public function setApiLogger(ApiLogger $logger)
    {
        $this->getHttpClient()->setLogger($logger);
        return $this;
    }

    /**
     * @return HttpClient
     */
    protected function getHttpClient()
    {
        if ($this->httpClient == null) {
            $this->httpClient = SkypeBot::getInstance()->getHttpClient();
        }
        return $this->httpClient;
    }

    public function call(Command $command)
    {
        $result = $this->callCommand($command);
        if ($result === false) {
            if ($command instanceof Authenticate) {
                throw new SecurityException('Failed to authenticate!');
            }
            $this->getTokenProvider()->getNewToken();
            return $this->callCommand($command);
        }
        return $command->processResult($result);
    }

    private function callCommand(Command $command)
    {
        $api = $command->getApi();
        $fullUrl = $api->getRequestUrl();
        if (!($command instanceof Authenticate)) {
            $this->getHttpClient()->setHeader(
                'Authorization',
                'Bearer ' . $this->getTokenProvider()->getAccessToken()->getToken()
            );
        }
        if ($api->getRequestMethod() == HttpClient::METHOD_POST) {
            if ($api->isJsonRequest()) {
                $result = $this->getHttpClient()->post($fullUrl, json_encode($api->getRequestParams()));
            } else {
                $result = $this->getHttpClient()->post($fullUrl, $api->getRequestParams());
            }
        } else {
            $result = $this->getHttpClient()->get($fullUrl, $api->getRequestParams());
        }
        if (!$result) {
            if ($this->getHttpClient()->getReturnCode() == 401) {
                return false;
            }
        }
        if ($api->getJsonResult()) {
            $json = json_decode($result);
            if ($json === null) {
                throw new ResponseException('Invalid Json format: ' . $result);
            }
            return $json;
        }

        return $result;
    }

    /**
     * @return TokenProvider
     */
    private function getTokenProvider()
    {
        if ($this->tokenProvider === null) {
            $this->tokenProvider = SkypeBot::getInstance()->getTokenProvider();
        }
        return $this->tokenProvider;
    }
}
