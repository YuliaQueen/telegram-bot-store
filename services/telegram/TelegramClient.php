<?php

namespace app\services\telegram;

use Telegram\Bot\Api;
use Telegram\Bot\Exceptions\TelegramSDKException;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Objects\Update;
use Telegram\Bot\Objects\User;
use Telegram\Bot\Objects\WebhookInfo;
use Yii;
use yii\base\Component;

class TelegramClient extends Component implements TelegramClientInterface
{
    const PARSE_MODE_HTML = 'HTML';

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
     */
    public function sendMessage($config): void
    {

        try {
            $chatId = $config['chat_id'];
            $text   = $config['text'];

            if (empty($chatId) || empty($text)) {
                throw new TelegramSDKException('Chat id or text not found');
            }

            $this->api->sendMessage($config);
        } catch (TelegramSDKException $e) {
            Yii::error($e->getMessage());
        }
    }

    /**
     * @param $params
     * @return Keyboard
     */
    public function generateKeyboard($params): Keyboard
    {
        return new Keyboard($params);
    }
}