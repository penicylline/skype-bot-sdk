# skype-bot-sdk
Skype bot framework PHP sdk

[![Build status](http://img.shields.io/travis/penicylline/skype-bot-sdk.svg?style=flat-square)](http://travis-ci.org/penicylline/skype-bot-sdk)
[![Scrutinizer Code Quality](http://img.shields.io/scrutinizer/g/penicylline/skype-bot-sdk.svg?style=flat-square)](https://scrutinizer-ci.com/g/penicylline/skype-bot-sdk)
[![Code Coverage](http://img.shields.io/scrutinizer/coverage/g/penicylline/skype-bot-sdk.svg?style=flat-square)](https://scrutinizer-ci.com/g/penicylline/skype-bot-sdk)

How to use
-------

Create new bot here
https://dev.botframework.com/bots/new
Set your bot's "Messaging endpoint" to https://yourdomain/listener.php

Initialize bot

```php
$dataStorate = new \SkypeBot\Storage\FileStorage(sys_get_temp_dir());
$config = new \SkypeBot\Config(
    'YOUR SKYPE BOT ID',
    'YOUR SKYPE BOT SECRET'
);

$bot = \SkypeBot\SkypeBot::init($config, $dataStorate);
```

In your notification listener (listener.php)

```php
$bot->getNotificationListener()->setMessageHandler(
    function($payload) {
        file_put_contents(
            sys_get_temp_dir() . '/conversation_id.txt',
            $payload->getConversation()->getId();
        );
    }
);
```

Send message to conversation

```php
$bot->getApiClient()->call(
    new \SkypeBot\Command\Message(
        'Hello World.',
        'Your conversation id'
    )
);
```
