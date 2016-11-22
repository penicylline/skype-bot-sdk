<?php

namespace SkypeBot\Interfaces;

use SkypeBot\Entity\MessagePayload;

interface MessageHandler
{
    public function handlerMessage(MessagePayload $message);
}