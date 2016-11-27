<?php

namespace SkypeBot\Entity;

use SkypeBot\Exception\PayloadException;

class Activity extends Entity
{
    const TYPE_TEXT = 'message/text';
    const TYPE_IMAGE = 'message/image';
    const TYPE_CARD = 'message/card';

    const LAYOUT_LIST = 'list';
    const LAYOUT_CAROUSEL = 'carousel';

    public function __construct()
    {
        parent::__construct();
        $this->rawObj->type = static::TYPE_TEXT;
    }

    public function setType($type)
    {
        return $this->set('type', $type);
    }

    public function getType()
    {
        return $this->get('type');
    }

    public function getText() {
        return $this->get('text');
    }

    public function setText($text)
    {
        $this->set('text', $text);
    }

    public function setAttachmentLayout($layout)
    {
        return $this->set('attachmentLayout', $layout);
    }

    public function getAttachmentLayout()
    {
        return $this->get('attachmentLayout');
    }

    public function addAttachment(Attachment $attachment)
    {
        $this->add('attachments', $attachment);
        if (count($this->rawObj->attachments) > 1 && property_exists($this->rawObj, 'attachmentLayout')) {
            $this->set('attachmentLayout', static::LAYOUT_CAROUSEL);
        }
        return $this;
    }
}