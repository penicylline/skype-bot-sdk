<?php

use PHPUnit_Framework_TestCase as TestCase;

class SkypeBotTest extends TestCase
{

    function testCI()
    {
        $config = new \SkypeBot\Config(1,2,3,4,5);
        $storage = new \SkypeBot\Storage\MemoryStorage();
        $bot = \SkypeBot\SkypeBot::init($config, $storage);
        $bot->set('aa', 1);
        $this->assertEquals($bot->get('aa'), 1);
        $bot->set('bb', function (){
            return 1;
        });
        $this->assertEquals($bot->get('bb'), 1);
    }
}