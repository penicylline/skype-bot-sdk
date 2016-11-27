<?php
namespace SkypeBot\Command;

use SkypeBot\Api\Api;
use SkypeBot\Entity\Activity;
use SkypeBot\SkypeBot;

class SendMessage extends Command {

    protected $message;
    protected $conversation;

    /**
     * Message constructor.
     * @param $message
     * @param $conversation
     */
    public function __construct($message, $conversation) {
        $this->message = $message;
        $this->conversation = $conversation;
    }

    /**
     * @return Api
     */
    public function getApi()
    {
        $config = SkypeBot::getInstance()->getConfig();
        $activity = new Activity();
        $activity->setText($this->message);
        return new Api(
            $config->getApiEndpoint() . '/v3/conversations/' . $this->conversation . '/activities',
            array(
                Api::PARAM_JSON_REQUEST => true,
                APi::PARAM_PARAMS => $activity->getRaw()
            )
        );
    }

    public function processResult($result)
    {
        return;
    }
}