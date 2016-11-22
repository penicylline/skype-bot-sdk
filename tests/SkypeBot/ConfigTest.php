<?php

use PHPUnit_Framework_TestCase as TestCase;

class ConfigTest extends TestCase
{

    function testConstructor()
    {
        $config = new \SkypeBot\Config(1,2,3,4,5);
        $this->assertEquals($config->getAppId(), 1);
        $this->assertEquals($config->getAppSecret(), 2);
        $this->assertEquals($config->getApiEndpoint(), 3);
        $this->assertEquals($config->getAuthEndpoint(), 4);
        $this->assertEquals($config->getOpenIdEndpoint(), 5);
    }
}