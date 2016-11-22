<?php

namespace SkypeBot\Entity;

class ContactUpdatePayload
{
    const ACTION_ADD = 'add';
    const ACTION_REMVOVE = 'remove';

    public function getAction() {
        return $this->get('action');
    }
}