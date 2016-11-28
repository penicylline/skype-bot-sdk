<?php

namespace SkypeBot\Entity\Card;

class VideoCard extends Base
{

    public function getContentType()
    {
        return 'application/vnd.microsoft.card.video';
    }
}