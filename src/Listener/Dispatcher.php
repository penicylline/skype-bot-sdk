<?php

namespace SkypeBot\Listener;

use SkypeBot\Entity\ContactUpdatePayload;
use SkypeBot\Entity\ConversationUpdatePayload;
use SkypeBot\Entity\MessagePayload;
use SkypeBot\Exception\PayloadException;
use SkypeBot\Exception\SecurityException;
use SkypeBot\Interfaces\ApiLogger;
use SkypeBot\Interfaces\ContactUpdateHandler;
use SkypeBot\Interfaces\ConversationUpdateHandler;
use SkypeBot\Interfaces\MessageHandler;
use SkypeBot\SkypeBot;

class Dispatcher
{
    /**
     * @var Security
     */
    protected $security;

    /**
     * @var MessageHandler
     */
    protected $messageHandler;

    /**
     * @var ContactUpdateHandler
     */
    protected $contactUpdateHandler;

    /**
     * @var ConversationUpdateHandler
     */
    protected $conversationUpdateHandler;

    /**
     * @var ApiLogger
     */
    protected $apiLogger;

    protected $headers;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function dispatch()
    {
        $payload = $this->fetchRequest();
        if ($payload instanceof MessagePayload) {
            $this->handleMessage($payload);
        }
        if ($payload instanceof ConversationUpdatePayload) {
            $this->handleConversationUpdate($payload);
        }
        if ($payload instanceof ContactUpdatePayload) {
            $this->handleContactUpdate($payload);
        }

        $this->sendResponse();
    }

    public function setContactHandler($handler)
    {
        $this->contactUpdateHandler = $handler;
        return $this;
    }

    public function setConversationHandler($handler)
    {
        $this->conversationUpdateHandler = $handler;
        return $this;
    }

    public function setMessageHandler($handler)
    {
        $this->messageHandler = $handler;
        return $this;
    }

    public function setApiLogger(ApiLogger $logger)
    {
        $this->apiLogger = $logger;
        return $this;
    }

    protected function fetchRequest()
    {
        $request = SkypeBot::getInstance()->getRequest();
        $headers = $request->getHeaders();
        if (!isset($headers['Authorization'])) {
            throw new SecurityException('Request missing authorization header');
        }
        $this->validateAuthenticateHeader($headers['Authorization']);

        $requestBody = $request->getRawBody();
        $requestObj = json_decode($requestBody);
        if (empty($requestObj)) {
            throw new PayloadException('Empty or invalid json format: "' . $requestBody . '"');
        }
        $this->logRequest($request->getHeaders(), $requestBody);
        return PayloadFactory::createPayload($requestObj);
    }

    protected function sendResponse()
    {
        http_response_code(201);
    }

    protected function handleMessage(MessagePayload $payload) {
        if ($this->messageHandler === null) {
            return;
        }
        if ($this->messageHandler instanceof MessageHandler) {
            return $this->messageHandler->handlerMessage($payload);
        }
        if (is_callable($this->messageHandler)){
            call_user_func_array($this->messageHandler, [$payload]);
        }
    }

    protected function handleContactUpdate(ContactUpdatePayload $payload) {
        if ($this->contactUpdateHandler === null) {
            return;
        }
        if ($this->contactUpdateHandler instanceof ContactUpdateHandler) {
            return $this->contactUpdateHandler->handlerPayload($payload);
        }
        if (is_callable($this->contactUpdateHandler)){
            call_user_func_array($this->contactUpdateHandler, [$payload]);
        }
    }

    protected function handleConversationUpdate(ConversationUpdatePayload $payload)
    {
        if ($this->conversationUpdateHandler === null) {
            return;
        }
        if ($this->conversationUpdateHandler instanceof ConversationUpdateHandler) {
            return $this->conversationUpdateHandler->handlerPayload($payload);
        }
        if (is_callable($this->conversationUpdateHandler)){
            call_user_func_array($this->conversationUpdateHandler, [$payload]);
        }
    }

    protected function validateAuthenticateHeader($authHeader)
    {
        $result = $this->security->validateBearerHeader($authHeader);
        if ($result != 1) {
            throw new SecurityException('Invalid authenticate data');
        }
    }

    protected function logRequest($requestHeader, $requestBody)
    {
        if ($this->apiLogger === null) {
            return;
        }
        $message = print_r($requestHeader, true) . PHP_EOL . $requestBody;
        $this->apiLogger->log($message);
    }
}