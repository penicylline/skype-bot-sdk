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

    function testSendActivity()
    {
        $activity = new \SkypeBot\Entity\Activity();
        $activity->setAttachmentLayout('list');
        $cmd = new \SkypeBot\Command\SendActivity($activity, 'cid');
        $this->assertEquals($cmd->getApi()->getRequestParams()->attachmentLayout, 'list');
        $resObj = new stdClass();
        $resObj->id = 12;
        $this->assertEquals($cmd->processResult($resObj)->getId(), 12);
    }

    function testSendMessage()
    {
        $cmd = new \SkypeBot\Command\SendMessage('aaa', 'bbb');
        $cmd->setResultProcessor(function ($result){
            return $result->getId();
        });
        $pos = strpos($cmd->getApi()->getRequestUrl(), 'bbb');
        $this->assertGreaterThan(0, $pos);
        $this->assertEquals($cmd->getApi()->getRequestParams()->text, 'aaa');
        $resObj = new stdClass();
        $resObj->id = 11;
        $this->assertEquals($cmd->processResult($resObj), 11);
    }

    function testSendAttachment()
    {
        $att = new \SkypeBot\Entity\Attachment();
        $card = new \SkypeBot\Entity\Card\AudioCard();
        $att->setContent($card);
        $cmd = new \SkypeBot\Command\SendAttachment($att, 'bbb', 'msg');
        $this->assertEquals($cmd->getApi()->getRequestParams()->attachments[0]->contentType, $att->getContentType());
        $this->assertTrue($cmd->getApi()->isJsonRequest());

        $mock = $this->getMock('SkypeBot\\Interfaces\\ApiResultProcessor');
        $mock->expects($this->any())
            ->method('processResult')
            ->will($this->returnValue(13));
        $cmd->setResultProcessor($mock);
        $this->assertEquals($cmd->processResult(null), 13);
    }

    function testDeleteActivity()
    {
        $cmd = new \SkypeBot\Command\DeleteActivity('a', 'b');
        $this->assertEquals($cmd->getApi()->getRequestMethod(), \SkypeBot\Api\HttpClient::METHOD_DELETE);
    }
}