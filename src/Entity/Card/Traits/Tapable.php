<?php

namespace SkypeBot\Entity\Card\Traits;

use SkypeBot\Entity\Card\CardAction;
use SkypeBot\Entity;

trait Tapable
{
    /**
     * @param CardAction $tap
     * @return $this
     */
    function setTap(CardAction $tap)
    {
        return $this->set('tap', $tap);
    }

    /**
     * @return null|CardAction
     */
    function getTap()
    {
        return $this->get('tap');
    }
}