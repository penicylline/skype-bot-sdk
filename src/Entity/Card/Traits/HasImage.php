<?php

namespace SkypeBot\Entity\Card\Traits;

use SkypeBot\Entity\Card\CardAction;
use SkypeBot\Entity;
use SkypeBot\Entity\Card\CardImage;

trait HasImage
{
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
        return $this->get('image', CardImage::class);
    }
}