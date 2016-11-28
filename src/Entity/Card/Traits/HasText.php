<?php

namespace SkypeBot\Entity\Card\Traits;

use SkypeBot\Entity\Card\CardAction;
use SkypeBot\Entity;

trait HasText
{
    /**
     * @param $text
     * @return $this
     */
    function setText($text)
    {
        return $this->set('text', $text);
    }

    /**
     * @return null|string
     */
    function getText()
    {
        return $this->get('text');
    }
}