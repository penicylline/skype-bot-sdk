<?php

namespace SkypeBot\Entity;

class ConversationUpdatePayload extends Payload
{
    public function getMembersAdded()
    {
        return $this->get('membersAdded');
    }

    public function getMembersRemoved()
    {
        return $this->get('membersRemoved');
    }

    public function getTopic()
    {
        return $this->get('topicName');
    }
}