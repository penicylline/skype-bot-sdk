<?php

namespace SkypeBot\Entity\Card\Traits;

use SkypeBot\Entity\Card\CardAction;
use SkypeBot\Entity;

trait HasSubtitle
{
    /**
     * @param $subtitle
     * @return mixed
     */
    function setSubtitle($subtitle)
    {
        return $this->set('subtitle', $subtitle);
    }

    /**
     * @return mixed
     */
    function getSubtitle()
    {
        return $this->get('subtitle');
    }
}