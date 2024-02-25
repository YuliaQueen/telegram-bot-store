<?php

namespace app\services\telegram;

use Telegram\Bot\Api;
use Telegram\Bot\Exceptions\TelegramSDKException;
use Telegram\Bot\Objects\Update;
use Telegram\Bot\Objects\User;
use Telegram\Bot\Objects\WebhookInfo;
use Yii;
use yii\base\Component;

class TelegramClient extends Component implements TelegramClientInterface
{
    private Api $api;

    /**
     * @throws TelegramSDKException
     */
    public function __construct()
    {
        parent::__construct();
        $this->api = new Api(Yii::$app->params['telegramApiKey']);
    }

    /**
     * @return User|array
     */
    public function getMe(): User|array
    {
        try {
            return $this->api->getMe();
        } catch (TelegramSDKException $e) {
            Yii::error($e->getMessage());
            Yii::$app->session->setFlash('error', $e->getMessage());

            return [];
        }
    }

    /**
     * @return Update
     */
    public function getWebhookUpdate(): Update
    {
        return $this->api->getWebhookUpdate();
    }

    /**
     * @throws TelegramSDKException
     */
    public function getUpdates(): array
    {
        return $this->api->getUpdates();
    }

    /**
     * @return bool
     * @throws TelegramSDKException
     */
    public function setWebhook(): bool
    {
        $params = [
            'url' => Yii::$app->params['telegramWebhookUrl'],
        ];
        return $this->api->setWebhook($params);
    }

    /**
     * @throws TelegramSDKException
     */
    public function deleteWebhook(): bool
    {
        return $this->api->deleteWebhook();
    }

    /**
     * @throws TelegramSDKException
     */
    public function getWebhookInfo(): WebhookInfo
    {
        return $this->api->getWebhookInfo();
    }

    /**
     * @throws TelegramSDKException
     */
    public function sendMessage($id, string $string): void
    {
        $this->api->sendMessage([
            'chat_id' => $id,
            'text'    => $string
        ]);
    }
}