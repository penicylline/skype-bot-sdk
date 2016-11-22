<?php

namespace SkypeBot\Interfaces;

use SkypeBot\Entity\ContactUpdatePayload;

interface ContactUpdateHandler
{
    public function handlerPayload(ContactUpdatePayload $payload);
}