<?php

namespace SkypeBot\Entity;

class MessagePayload extends Payload
{
    public function getText()
    {
        $pattern = '/<[^\>]+>([^\<]+)<[^\>]+>/';
        $text = preg_replace($pattern, '$1', trim($this->get('text')));
        $text = str_replace("\xc2\xa0", ' ', $text);
        return html_entity_decode($text);
    }

    public function setText($text)
    {
        $this->set('text', $text);
    }
}