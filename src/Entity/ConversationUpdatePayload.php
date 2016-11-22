<?php

namespace SkypeBot\Entity;

class ConversationUpdatePayload
{
    public function getMembersAdded() {
        return $this->get('membersAdded');
    }

    public function getMembersRemoved() {
        return $this->get('membersRemoved');
    }
}