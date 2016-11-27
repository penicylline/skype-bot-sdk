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

    function testSendMessage()
    {
        $cmd = new \SkypeBot\Command\SendMessage('aaa', 'bbb');
        $pos = strpos($cmd->getApi()->getRequestUrl(), 'bbb');
        $this->assertGreaterThan(0, $pos);
        $this->assertEquals($cmd->getApi()->getRequestParams()->text, 'aaa');
    }

    function testSendAttachment()
    {
        $att = new \SkypeBot\Entity\Attachment();
        $card = new \SkypeBot\Entity\Card\AudioCard();
        $att->setContent($card);
        $cmd = new \SkypeBot\Command\SendAttachment($att, 'bbb');
        $this->assertEquals($cmd->getApi()->getRequestParams()->attachments[0]->contentType, $att->getContentType());
        $this->assertTrue($cmd->getApi()->isJsonRequest());
    }
}