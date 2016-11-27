<?php
namespace SkypeBot\Api;

class Api {
    const PARAM_METHOD = 'method';
    const PARAM_PARAMS = 'params';
    const PARAM_HEADERS = 'headers';
    const PARAM_URL = 'url';
    const PARAM_JSON_RESPONSE = 'json_response';
    const PARAM_JSON_REQUEST = 'json_request';

    protected $requestParams;
    protected $requestUrl;
    protected $options;
    protected $jsonRequest;

    public function __construct($url, array $options = [])
    {
        $this->requestUrl = $url;
        if (isset($options[static::PARAM_PARAMS])) {
            $this->requestParams = $options[static::PARAM_PARAMS];
        }
        if (isset($options[static::PARAM_JSON_REQUEST])) {
            $this->jsonRequest = $options[static::PARAM_JSON_REQUEST];
        }
        $this->options = $options;
    }

    public function setHeader($key, $value)
    {
        $this->options[static::PARAM_HEADERS][$key] = $value;
        return $this;
    }

    public function setRequestMethod($method)
    {
        if ($method === HttpClient::METHOD_GET) {
            $this->options[static::PARAM_METHOD] = HttpClient::METHOD_GET;
        } else {
            $this->options[static::PARAM_METHOD] = HttpClient::METHOD_POST;
        }
        return $this;
    }

    public function getRequestMethod() {
        if (isset($this->options[static::PARAM_METHOD]))
        {
            return $this->options[static::PARAM_METHOD];
        }
        return HttpClient::METHOD_POST;
    }

    public function getRequestParams()
    {
        return $this->requestParams;
    }

    public function getRequestUrl()
    {
        return $this->requestUrl;
    }

    public function getRequestHeaders() {
        if (isset($this->options[static::PARAM_HEADERS]))
        {
            return $this->options[static::PARAM_HEADERS];
        }
    }

    public function isJsonRequest() {
        if ($this->requestParams instanceof \stdClass) {
            return true;
        }
        return $this->jsonRequest ? true : false;
    }

    public function getJsonResult() {
        if (isset($this->options[static::PARAM_JSON_RESPONSE]))
        {
            return $this->options[static::PARAM_JSON_RESPONSE];
        }
        return true;
    }

    public function setParam($key, $value)
    {
        $this->requestParams[$key] = $value;
        return $this;
    }

    public function setParams($values)
    {
        $this->requestParams = array_merge($this->requestParams, $values);
        return $this;
    }
}