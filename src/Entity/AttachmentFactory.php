<?php

namespace SkypeBot\Entity;


use SkypeBot\Entity\Card\MediaUrl;
use SkypeBot\Entity\Card\VideoCard;
use SkypeBot\Exception\PayloadException;

class AttachmentFactory
{
    const MEDIA_IMAGE = 'image';
    const MEDIA_VIDEO = 'video';
    const MEDIA_AUDIO = 'audio';

    /**
     * @param $url
     * @param null $name
     * @return Attachment
     */
    public static function createMedia($type, $url, $name = null)
    {
        $types = [static::MEDIA_IMAGE, static::MEDIA_VIDEO, static::MEDIA_AUDIO];
        if (!in_array($type, $types)) {
            throw new PayloadException('Unsupported media type: ' . $type);
        }
        $attachment = new Attachment();
        $attachment->setContentType($type);
        $attachment->setContentUrl($url);
        if ($name) {
            $attachment->setName($name);
        }
        return $attachment;
    }
}