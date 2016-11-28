<?php

namespace SkypeBot\Entity\Card;

class AudioCard extends MediaCard
{

    public function getContentType()
    {
        return 'application/vnd.microsoft.card.audio';
    }

    function setAspect($aspect)
    {
        return $this->set('aspect', $aspect);
    }

    function getAspect()
    {
        return $this->get('aspect');
    }
}