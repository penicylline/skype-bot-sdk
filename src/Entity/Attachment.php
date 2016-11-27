<?php

namespace SkypeBot\Entity;

use SkypeBot\Entity\Card\Base;

class Attachment extends Entity
{
    public function setContentType($type)
    {
        return $this->set('contentType', $type);
    }

    public function getContentType()
    {
        return $this->get('contentType');
    }

    public function setContentUrl($url)
    {
        return $this->set('contentUrl', $url);
    }

    public function getContentUrl()
    {
        return $this->get('contentUrl');
    }

    public function setContent(Base $content)
    {
        $this->setContentType($content->getContentType());
        return $this->set('content', $content);
    }

    public function getContent()
    {
        return $this->get('content');
    }

    public function setName($name)
    {
        return $this->set('name', $name);
    }

    public function getName()
    {
        return $this->get('name');
    }

    public function setThumbnailUrl($url)
    {
        return $this->set('thumbnailUrl', $url);
    }

    public function getThumbnailUrl()
    {
        return $this->get('thumbnailUrl');
    }
}