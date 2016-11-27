<?php

namespace SkypeBot\Entity\Card;

use SkypeBot\Entity\Entity;

class CardAction extends Entity
{
    const TYPE_DOWNLOAD_FILE = 'downloadFile';
    const TYPE_IM_BACK = 'imBack';
    const TYPE_OPEN_URL = 'openUrl';
    const TYPE_PLAY_AUDIO = 'playAudio';
    const TYPE_PLAY_VIDEO = 'playVideo';
    const TYPE_POST_BACK = 'postBack';


    function setImage($image)
    {
        return $this->set('image', $image);
    }

    function getImage()
    {
        return $this->get('image');
    }

    function setTitle($title)
    {
        return $this->set('title', $title);
    }

    function getTitle()
    {
        return $this->get('title');
    }

    function setType($type)
    {
        return $this->set('type', $type);
    }

    function getType()
    {
        return $this->get('type');
    }

    function setValue($value)
    {
        return $this->set('value', $value);
    }

    function getValue()
    {
        return $this->get('value');
    }
}