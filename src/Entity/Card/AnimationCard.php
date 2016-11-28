<?php

namespace SkypeBot\Entity\Card;

class AnimationCard extends MediaCard
{

    public function getContentType()
    {
        return 'application/vnd.microsoft.card.animation';
    }
}