<?php
namespace SkypeBot\Entity;

class Conversation extends Address
{
    public function isGroup() {
        return $this->get('isGroup');
    }

    public function setIsGroup($isGroup)
    {
        return $this->set('isGroup', $isGroup);
    }
}