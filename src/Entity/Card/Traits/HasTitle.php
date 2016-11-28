<?php

namespace SkypeBot\Entity\Card\Traits;

trait HasTitle
{
    /**
     * @param $title
     * @return $this
     */
    function setTitle($title)
    {
        return $this->set('title', $title);
    }

    /**
     * @return null|string
     */
    function getTitle()
    {
        return $this->get('title');
    }
}