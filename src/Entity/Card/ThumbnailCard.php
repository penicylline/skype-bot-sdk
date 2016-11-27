<?php

namespace SkypeBot\Entity\Card;

class ThumbnailCard extends Base
{

    public function getContentType()
    {
        return 'application/vnd.microsoft.card.thumbnail';
    }

    function addImage(CardImage $image)
    {
        return $this->add('images', $image);
    }

    function getImages()
    {
        return $this->get('images');
    }

    function setSubtitle($subtitle)
    {
        return $this->set('subtitle', $subtitle);
    }

    function getSubtitle()
    {
        return $this->get('subtitle');
    }

    function setTap(CardAction $tap)
    {
        return $this->set('tap', $tap);
    }

    /**
     * @return null|CardAction
     */
    function getTap()
    {
        return $this->get('tap', CardAction::class);
    }


}