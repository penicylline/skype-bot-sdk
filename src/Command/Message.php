<?php
namespace SkypeBot\Command;

use SkypeBot\Api\Api;
use SkypeBot\SkypeBot;

class Message extends Command {

    protected $message;
    protected $conversation;

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
        return new Api(
            $config->getApiEndpoint() . '/v3/conversations/' . $this->conversation . '/activities',
            array(
                Api::PARAM_JSON_REQUEST => true,
                APi::PARAM_PARAMS => array(
                    'type' => 'message/text',
                    'text' => $this->message
                )
            )
        );
    }

    public function processResult($result)
    {
        return;
    }
}