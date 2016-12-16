# skype-bot-sdk
Skype bot framework PHP sdk

[![Build Status](https://travis-ci.org/penicylline/skype-bot-sdk.svg?branch=master)](https://travis-ci.org/penicylline/skype-bot-sdk)
[![Code Climate](https://codeclimate.com/github/penicylline/skype-bot-sdk/badges/gpa.svg)](https://codeclimate.com/github/penicylline/skype-bot-sdk)
[![Test Coverage](https://codeclimate.com/github/penicylline/skype-bot-sdk/badges/coverage.svg)](https://codeclimate.com/github/penicylline/skype-bot-sdk/coverage)
[![Issue Count](https://codeclimate.com/github/penicylline/skype-bot-sdk/badges/issue_count.svg)](https://codeclimate.com/github/penicylline/skype-bot-sdk)

How to use
-------

Create new application, get app id and app password

https://apps.dev.microsoft.com/#/quickstart/skypebot

Create your bot

https://dev.botframework.com/bots/new
 
Set your bot's "Messaging endpoint" to https://yourdomain/listener.php

Installation

composer require penicylline/skype-bot-sdk
or require_once <vendor_dir>/SkypeBot/autoload.php

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
    new \SkypeBot\Command\SendMessage(
        'Hello World.',
        'Your conversation id'
    )
);
```
