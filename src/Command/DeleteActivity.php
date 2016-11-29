<?php
namespace SkypeBot\Command;

use SkypeBot\Api\Api;
use SkypeBot\Api\HttpClient;
use SkypeBot\Entity\Activity;
use SkypeBot\Entity\Attachment;
use SkypeBot\Entity\AttachmentFactory;
use SkypeBot\Entity\Result;
use SkypeBot\SkypeBot;

class DeleteActivity extends ApiCommand {

    protected $activityId;
    protected $conversation;

    /**
     * Message constructor.
     * @param $message
     * @param $conversation
     */
    public function __construct($activityId, $conversation) {
        $this->activityId = $activityId;
        $this->conversation = $conversation;
    }

    /**
     * @return Api
     */
    public function getApi()
    {
        $config = SkypeBot::getInstance()->getConfig();
        $api = new Api(
            $config->getApiEndpoint() . '/v3/conversations/' . $this->conversation . '/activities/' . $this->activityId
        );
        $api->setRequestMethod(HttpClient::METHOD_DELETE);
        return $api;
    }
}