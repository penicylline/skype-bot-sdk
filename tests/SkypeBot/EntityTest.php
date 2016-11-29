<?php

use PHPUnit_Framework_TestCase as TestCase;

class EntityTest extends TestCase
{

    function testMessagePayload()
    {
        $obj = json_decode('
        {
            "channelId":"skype",
            "serviceUrl":"https://apis.skype.com",
            "conversation": {
                "id":"111",
                "name":"Alice",
                "isGroup":true
            },
            "from": {
                "id":"id_from",
                "name":"Alice Smith"
            },
            "recipient": {
                "id":"28:agentId",
                "name":"recipient_name"
            },
            "id":"1234567890",
            "type":"message/text",
            "text":"hello"
        }');
        $message = \SkypeBot\Listener\PayloadFactory::createPayload($obj);
        $this->assertEquals($message->getType(), \SkypeBot\Entity\Payload::TYPE_MESSAGE_TEXT);
        $this->assertEquals($message->getChannelId(), 'skype');
        $this->assertEquals($message->getConversation()->getId(), 111);
        $this->assertEquals($message->getServiceUrl(), 'https://apis.skype.com');
        $this->assertEquals($message->getFrom()->getId(), 'id_from');
        $this->assertEquals($message->getRecipient()->getName(), 'recipient_name');
        $this->assertEquals($message->getText(), 'hello');
        $this->assertEquals($message->getConversation()->isGroup(), true);

        $this->assertEquals($message->getRaw(), $obj);
    }

    function testConversationUpdatePayload()
    {
        $obj = json_decode('
        {
            "channelId":"skype",
            "serviceUrl":"https://apis.skype.com",
            "conversation": {
                "id":"cid",
                "isGroup":true
            },
            "from": {
                "id":"fid",
                "name":"Display Name"
            },
            "recipient": {
                "id":"rid",
                "name":"Trivia Master"
            },
            "type":"activity/conversationUpdate",
            "membersAdded":["a"],
            "membersRemoved":["b"],
            "topicName": "new_name"
        }
        ');
        $update = \SkypeBot\Listener\PayloadFactory::createPayload($obj);
        $this->assertEquals($update->getMembersAdded(), ["a"]);
        $this->assertEquals($update->getMembersRemoved(), ["b"]);
        $this->assertEquals($update->getTopic(), 'new_name');
    }

    function testContactUpdatePayload()
    {
        $obj = json_decode('
        {
            "channelId":"skype",
            "serviceUrl":"https://apis.skype.com",
            "conversation": {
                "id":"29:f2ca6a4a-93bd-434a-9ca5-5f81f8f9b455",
                "name":"Display Name"
            },
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
        ');
        $update = \SkypeBot\Listener\PayloadFactory::createPayload($obj);
        $this->assertEquals($update->getAction(), \SkypeBot\Entity\ContactUpdatePayload::ACTION_ADD);
    }

    function testJWKPayload()
    {
        $obj = json_decode('
        {
            "iss":"1",
            "aud":"2",
            "exp":"3",
            "nbf":"4"
        }
        ');
        $payload = new \SkypeBot\Entity\Jwk\JwkPayload($obj);
        $this->assertEquals($payload->getExpired(), 3);
        $this->assertEquals($payload->getNotBefore(), 4);
    }

    function testJWKInfo()
    {
        $obj = json_decode('
        {
            "typ":"1",
            "alg":"2",
            "kid":"3",
            "x5t":"4"
        }
        ');
        $info = new \SkypeBot\Entity\Jwk\JwkInfo($obj);
        $this->assertEquals($info->getAlgorithm(), 2);
        $this->assertEquals($info->getKeyId(), 3);
        $this->assertEquals($info->getType(), 1);
    }

    function testResult()
    {
        $obj = json_decode('
        {
            "error": {"message": "e"},
            "id": "1"
        }
        ');
        $result = new \SkypeBot\Entity\Result($obj);
        $this->assertEquals($result->getError()->getMessage(), 'e');
        $this->assertEquals($result->getId(), 1);
    }

    function testAttachmentFactory()
    {
        $attachment = \SkypeBot\Entity\AttachmentFactory::createMedia(
            \SkypeBot\Entity\AttachmentFactory::MEDIA_AUDIO,
            'u',
            'n'
        );
        $this->assertEquals($attachment->getContentUrl(), 'u');
        $this->assertEquals($attachment->getName(), 'n');
        try {
            \SkypeBot\Entity\AttachmentFactory::createMedia(
                'exception',
                'u'
            );
        } catch (\SkypeBot\Exception\PayloadException $ex) {
            $msg = $ex->getMessage();
        }

        $this->assertNotNull($msg);
    }

}