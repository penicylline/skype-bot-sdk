<?php
namespace SkypeBot\Command;

use SkypeBot\Entity\Activity;

class SendMessage extends SendActivity  {

    /**
     * Message constructor.
     * @param $message
     * @param $conversation
     */
    public function __construct($message, $conversation) {
        $this->activity = new Activity();
        $this->activity->setText($message);
        $this->conversation = $conversation;
    }
}