<?php

use PHPUnit_Framework_TestCase as TestCase;

class DispatcherTest extends TestCase
{
    /**
     * @var \SkypeBot\SkypeBot
     */
    private  $bot;

    public function setUp()
    {
        $config = new \SkypeBot\Config(1,2,3,4,5);
        $storage = new \SkypeBot\Storage\MemoryStorage();
        $this->bot = \SkypeBot\SkypeBot::init($config, $storage);
        $securityMock = $this->getMock('\\SkypeBot\\Listener\\Security');
        $securityMock->expects($this->any())
            ->method('validateBearerHeader')
            ->will($this->returnValue(1));

        $this->bot->set('security', $securityMock);

        $message = '
        {
            "channelId":"skype",
            "serviceUrl":"https://apis.skype.com",
            "conversation": {
                "id":"111",
                "name":"Alice",
                "isGroup":true
            },
            "id":"1234567890",
            "type":"message/text",
            "text":"hello"
        }
        ';

        $contact = '
        {
            "channelId":"skype",
            "serviceUrl":"https://apis.skype.com",
            "from": {
                "id":"29:f2ca6a4a-93bd-434a-9ca5-5f81f8f9b455",
                "name":"Display Name"
            },
            "recipient": {
                "id":"28:ad35d471-ae65-4626-af00-c01ffbfc581f",
                "name":"Trivia Master"
            },
            "type":"activity/contactRelationUpdate",
            "action":"add"
        }
        ';

        $conversation = '
        {
            "channelId":"skype",
            "serviceUrl":"https://apis.skype.com",
            "conversation": {
                "id":"cid",
                "isGroup":true
            },
            "type":"activity/conversationUpdate",
            "membersAdded":["a"],
            "membersRemoved":["b"],
            "topicName": "new_name"
        }
        ';

        $headers = ['Authorization' => 'a'];
        $mock = $this->getMock('\\SkypeBot\\Listener\\Request');
        $mock->expects($this->any())
            ->method('getHeaders')
            ->will($this->returnValue($headers));
        $mock->expects($this->at(1))
            ->method('getRawBody')
            ->will($this->returnValue($message));
        $mock->expects($this->at(4))
            ->method('getRawBody')
            ->will($this->returnValue($contact));
        $mock->expects($this->at(7))
            ->method('getRawBody')
            ->will($this->returnValue($conversation));

        $this->bot->set('request', $mock);
    }

    function testHandler()
    {
        $this->bot->getNotificationListener()->setMessageHandler(function($payload){
            echo $payload->getText();
        });
        $this->bot->getNotificationListener()->setContactHandler(function($payload){
            echo $payload->getAction();
        });
        $this->bot->getNotificationListener()->setConversationHandler(function($payload){
            echo $payload->getMembersAdded()[0];
        });

        $this->bot->getNotificationListener()->dispatch();
        $this->expectOutputString("hello");
        $this->bot->getNotificationListener()->dispatch();
        $this->expectOutputString("helloadd");
        $this->bot->getNotificationListener()->dispatch();
        $this->expectOutputString("helloadda");
    }
}