<?php
namespace SkypeBot\Command;

use SkypeBot\Api\Api;
use SkypeBot\Entity\Activity;
use SkypeBot\Entity\Attachment;
use SkypeBot\Entity\AttachmentFactory;
use SkypeBot\SkypeBot;

class SendAttachment extends Command {

    protected $attachment;
    protected $message;
    protected $conversation;

    /**
     * Message constructor.
     * @param $message
     * @param $conversation
     */
    public function __construct(Attachment $attachment, $conversation, $message = null) {
        $this->attachment = $attachment;
        $this->conversation = $conversation;
        $this->message = $message;
    }

    /**
     * @return Api
     */
    public function getApi()
    {
        $config = SkypeBot::getInstance()->getConfig();
        $activity = new Activity();
        $activity->addAttachment($this->attachment);
        if ($this->message) {
            $activity->setText($this->message);
        }
        return new Api(
            $config->getApiEndpoint() . '/v3/conversations/' . $this->conversation . '/activities',
            array(
                APi::PARAM_PARAMS => $activity->getRaw()
            )
        );
    }

    public function processResult($result)
    {
        return;
    }
}