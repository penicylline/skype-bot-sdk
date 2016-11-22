<?php

namespace SkypeBot\Interfaces;

use SkypeBot\Entity\ConversationUpdatePayload;

interface ConversationUpdateHandler
{
    public function handlerPayload(ConversationUpdatePayload $payload);
}