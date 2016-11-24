<?php

use PHPUnit_Framework_TestCase as TestCase;

class CommandTest extends TestCase
{
    function setUp()
    {
        $config = new \SkypeBot\Config(1,2,3,4,5);
        $storage = new \SkypeBot\Storage\MemoryStorage();
        \SkypeBot\SkypeBot::init($config, $storage);
    }

    function testMessage()
    {
        $cmd = new \SkypeBot\Command\Message('aaa', 'bbb');
        $pos = strpos($cmd->getApi()->getRequestUrl(), 'bbb');
        $this->assertGreaterThan(0, $pos);
        $this->assertEquals($cmd->getApi()->getRequestParams()['text'], 'aaa');
    }
}