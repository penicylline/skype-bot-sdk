<?php

use PHPUnit_Framework_TestCase as TestCase;

class HttpClientTest extends TestCase
{

    function testGet()
    {
        $client = \SkypeBot\Api\HttpClient::getInstance();
        $client->setHeader('a', 'b');
        $client->setHeader('c: d');
        $res = $client->get('http://mockbin.com/request', ['c' => 'd']);
        $obj = json_decode($res);
        $this->assertEquals($obj->headers->a, 'b');
        $this->assertEquals($obj->headers->c, 'd');
        $this->assertEquals($obj->queryString->c, 'd');

        $res = $client->get('http://mockbin.com/request?a=b');
        $obj = json_decode($res);
        $this->assertEquals($obj->queryString->a, 'b');
        $this->assertEquals($client->getReturnCode(), 200);
    }

    function testPost()
    {
        $client = \SkypeBot\Api\HttpClient::getInstance();
        $res = $client->post('http://mockbin.com/request', ['c' => 'd']);
        $obj = json_decode($res);
        $this->assertEquals($obj->postData->params->c, 'd');
    }

    function testApi()
    {
        $api = new \SkypeBot\Api\Api(
            'a'
        );
        $api->setRequestMethod(\SkypeBot\Api\HttpClient::METHOD_GET);
        $this->assertEquals($api->getRequestMethod(), \SkypeBot\Api\HttpClient::METHOD_GET);
        $api->setRequestMethod('other');
        $this->assertEquals($api->getRequestMethod(), \SkypeBot\Api\HttpClient::METHOD_POST);
        $api->setParam('a', 'b');
        $api->setParams(['c' => 'd']);
        $params = $api->getRequestParams();
        $this->assertEquals($params['a'], 'b');
        $this->assertEquals($params['c'], 'd');
        $api->setHeader('a', 'b');
        $headers = $api->getRequestHeaders();
        $this->assertEquals($headers['a'], 'b');
    }
}