<?php

namespace SkypeBot\Entity\Card;

use SkypeBot\Entity\Entity;

abstract class Base extends Entity
{
    public function __construct()
    {
        $this->rawObj = new \stdClass();
    }

    function setText($text)
    {
        return $this->set('text', $text);
    }

    function getText()
    {
        return $this->get('text');
}

    function setTitle($title)
    {
        return $this->set('title', $title);
    }

    function getTitle()
    {
        return $this->get('title');
    }

    function addButton(CardAction $button)
    {
        return $this->add('buttons', $button);
    }

    function getButtons()
    {
        return $this->get('buttons');
    }

    public abstract function getContentType();
}