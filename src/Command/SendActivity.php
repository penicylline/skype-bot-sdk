<?php
namespace SkypeBot\Command;

use SkypeBot\Api\Api;
use SkypeBot\Entity\Activity;
use SkypeBot\Entity\Attachment;
use SkypeBot\Entity\AttachmentFactory;
use SkypeBot\Entity\Result;
use SkypeBot\SkypeBot;

class SendActivity extends ApiCommand
{

    protected $activity;
    protected $conversation;

    /**
     * Message constructor.
     * @param $message
     * @param $conversation
     */
    public function __construct(Activity $activity, $conversation) {
        $this->activity = $activity;
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
                APi::PARAM_PARAMS => $this->activity->getRaw()
            )
        );
    }

    /**
     * @return Activity
     */
    public function getActivity()
    {
        return $this->activity;
    }

    /**
     * @return mixed
     */
    public function getConversation()
    {
        return $this->conversation;
    }


}