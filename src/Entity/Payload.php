<?php

namespace SkypeBot\Entity;

class Payload extends Entity
{
    const TYPE_MESSAGE_TEXT = 'message_text';
    const TYPE_CONTACT_UPDATE = 'contact_update';
    const TYPE_CONVERSATION_UPDATE = 'conversation_update';
    const TYPE_UNKNOWN = 'unknown';

    protected $type;

    public function getChannelId()
    {
        return $this->get('channelId');
    }

    public function getServiceUrl()
    {
        return $this->get('serviceUrl');
    }

    /**
     * @return Conversation
     */
    public function getConversation()
    {
        return $this->get('conversation', Conversation::class);
    }

    /**
     * @return Address
     */
    public function getFrom()
    {
        return $this->get('from', Address::class);
    }

    /**
     * @return Address
     */
    public function getRecipient()
    {
        return $this->get('recipient', Address::class);
    }

    public function getType()
    {
        if ($this->type == null) {
            switch ($this->get('type')) {
                case 'message/text':
                case 'message':
                    $this->type = static::TYPE_MESSAGE_TEXT;
                    break;
                case 'activity/contactRelationUpdate':
                case 'contactRelationUpdate':
                    $this->type = static::TYPE_CONTACT_UPDATE;
                    break;
                case 'activity/conversationUpdate':
                case 'conversationUpdate':
                    $this->type = static::TYPE_CONVERSATION_UPDATE;
                    break;
                default:
                    $this->type = static::TYPE_UNKNOWN;
            }
        }
        return $this->type;
    }

    /**
     * @return array
     */
    protected function getRequiredFields()
    {
        return array();
    }
}