<?php

namespace SkypeBot\Entity\Card;

class HeroCard extends Base
{

    public function getContentType()
    {
        return 'application/vnd.microsoft.card.hero';
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

    function setTab(CardAction $tab)
    {
        return $this->set('tab', $tab);
    }

    /**
     * @return null|CardAction
     */
    function getTab()
    {
        return $this->get('tab');
    }

}