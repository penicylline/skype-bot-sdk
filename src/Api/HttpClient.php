<?php
namespace SkypeBot\Api;

use SkypeBot\Exception\CurlException;
use SkypeBot\Exception\ResponseException;
use SkypeBot\Interfaces\ApiLogger;
use SkypeBot\Storage\SimpleApiLogger;

class HttpClient {

    const METHOD_POST = 'post';
    const METHOD_GET = 'get';

    protected $headers = array();
    protected $cookies = array();
    protected $error;
    protected $info;
    private static $instance;

    /**
     * @var ApiLogger
     */
    private $logger;

    private function __construct()
    {
    }

    /**
     * @return HttpClient
     */
    public static function getInstance()
    {
        if (static::$instance == null) {
            static::$instance = new HttpClient();
        }
        return static::$instance;
    }

    /**
     * @param ApiLogger $logger
     * @return $this
     */
    public function setLogger(ApiLogger $logger)
    {
        $this->logger = $logger;
        return $this;
    }

    /**
     * @param $header
     * @param null $value
     * @return $this
     */
    public function setHeader($header, $value = null)
    {
        if ($value === null) {
            $this->headers[] = $header;
        } else {
            $this->headers[$header] = $value;
        }
        return $this;
    }

    /**
     * @param $url
     * @param array $params
     * @return bool
     */
    public function get($url, $params = array())
    {
        if (empty($params)) {
            $params = array();
        }
        $strParams = http_build_query($params);
        $channel = $this->initCurl();
        if (strpos($url, '?')) {
            if (substr($url, -1) == '&') {
                $url .= $strParams;
            } else {
                $url .= '&' . $strParams;
            }
        } else {
            if (count($params)) {
                $url .= '?' . $strParams;
            }
        }
        $this->log('>>>>>> GET >>>>>>');
        $this->log($url);
        curl_setopt($channel, CURLOPT_URL, $url);

        $result = $this->fetchResult($channel);
        if (!$result) {
            $this->error = curl_error($channel);
        }
        $this->closeCurl($channel);
        return $result;
    }

    public function post($url, $params = array())
    {
        $this->log('>>>>>> POST >>>>>>');
        $this->log($url);
        $this->log(print_r($params, true));
        if (is_string($params)) {
            $strParams = $params;
        } else {
            $strParams = http_build_query($params);
        }
        $channel = $this->initCurl();
        
        curl_setopt($channel, CURLOPT_URL, $url);
        if (!is_string($params)) {
            curl_setopt($channel, CURLOPT_POST, count($params));
        }
        curl_setopt($channel, CURLOPT_POSTFIELDS, $strParams);

        $result = $this->fetchResult($channel);
        if (!$result) {
            $this->error = curl_error($channel);
            $this->log($this->error);
        }
        $this->closeCurl($channel);
        return $result;
    }

    public function getError() {
        return $this->error;
    }

    protected function fetchResult($channel)
    {
        $this->log('===============================');
        $response = curl_exec($channel);
        $this->log($response);
        $headerSize = curl_getinfo($channel, CURLINFO_HEADER_SIZE);
        $body = substr($response, $headerSize);
        return $body;
    }

    public function getReturnCode()
    {
        if (is_array($this->info) && isset($this->info['http_code'])) {
            return $this->info['http_code'];
        }
        return null;
    }

    private function initCurl()
    {
        $channel = curl_init();
        curl_setopt($channel, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($channel, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($channel, CURLOPT_HEADER, 1);
        curl_setopt($channel, CURLOPT_HTTPHEADER, $this->buildHeaders());
        return $channel;
    }

    private function closeCurl($channel)
    {
        $this->info = curl_getinfo($channel);
        curl_close($channel);
    }

    private function buildHeaders()
    {
        $headers = array();
        foreach ($this->headers as $key => $value) {
            if (is_numeric($key)) {
                $headers[] = $value;
            } else {
                $headers[] = $key . ': ' . $value;
            }
        }
        return $headers;
    }

    private function log($message)
    {
        if ($this->logger === null) {
            return;
        }
        $this->logger->log($message);
    }
}
