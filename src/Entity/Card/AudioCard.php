<?php

namespace SkypeBot\Entity\Card;

class AudioCard extends Base
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

    function setMedia(MediaUrl $media)
    {
        return $this->set('media', $media);
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