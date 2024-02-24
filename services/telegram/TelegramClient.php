<?php

namespace app\services\telegram;

use Telegram\Bot\Api;
use Telegram\Bot\Exceptions\TelegramSDKException;
use Telegram\Bot\Objects\User;
use Yii;
use yii\base\Component;

class TelegramClient extends Component implements TelegramClientInterface
{
    private $api;

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
    public function getMe()
    {
        try {
            return $this->api->getMe();
        } catch (TelegramSDKException $e) {
            Yii::error($e->getMessage());
            Yii::$app->session->setFlash('error', $e->getMessage());

            return [];
        }
    }
}