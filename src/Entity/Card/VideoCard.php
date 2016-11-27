<?php

namespace SkypeBot\Entity\Card;

class VideoCard extends Base
{

    public function getContentType()
    {
        return 'application/vnd.microsoft.card.video';
    }

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
     * @param CardImage $image
     * @return $this
     */
    function setImage(CardImage $image)
    {
        return $this->set('image', $image);
    }

    /**
     * @return null|CardImage
     */
    function getImage()
    {
        return $this->get('image');
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

    function setSubtitle($subtitle)
    {
        return $this->set('subtitle', $subtitle);
    }

    function getSubtitle()
    {
        return $this->get('subtitle');
    }
}