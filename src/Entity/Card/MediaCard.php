<?php

namespace SkypeBot\Entity\Card;

use SkypeBot\Entity\Card\Traits\HasImage;
use SkypeBot\Entity\Card\Traits\HasSubtitle;

abstract class MediaCard extends Base
{
    use HasSubtitle;
    use HasImage;

    function setAutoloop($autoloop)
    {
        return $this->set('autoloop', $autoloop);
    }

    function getAutoloop()
    {
        return $this->get('autoloop');
    }

    function setAutostart($autostart)
    {
        return $this->set('autostart', $autostart);
    }

    function getAutostart()
    {
        return $this->get('autostart');
    }

    /**
     * @param MediaUrl $media
     * @return $this
     */
    function addMedia(MediaUrl $media)
    {
        return $this->add('media', $media);
    }

    /**
     * @return null|MediaUrl
     */
    function getMedia()
    {
        return $this->get('media');
    }

    function setShareable($shareable)
    {
        return $this->set('shareable', $shareable);
    }

    function getShareable()
    {
        return $this->get('shareable');
    }
}