<?php

namespace SkypeBot\Entity\Card;

use SkypeBot\Entity\Entity;

class ReceiptItem extends Entity
{
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

    function setPrice($price)
    {
        return $this->set('price', $price);
    }

    function getPrice()
    {
        return $this->get('price');
    }

    function setQuantity($quantity)
    {
        return $this->set('quantity', $quantity);
    }

    function getQuantity()
    {
        return $this->get('quantity');
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
        return $this->get('tap');
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
}