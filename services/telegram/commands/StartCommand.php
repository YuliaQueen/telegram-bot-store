<?php

namespace app\services\telegram\commands;

use app\enums\Phrases;
use app\services\telegram\TelegramClient;
use Yii;
use yii\helpers\Url;

class StartCommand extends BaseCommand
{
    /**
     * @param int    $chatId
     * @param string $name
     * @param null   $data
     * @inheritDoc
     */
    public function execute($chatId, $name, $data = null): void
    {
        $this->tg->sendMessage([
            'chat_id'      => $chatId,
            'text'         => Yii::t('app', 'Привет, {name}!', ['name' => $name]),
            'parse_mode'   => TelegramClient::PARSE_MODE_HTML,
            'reply_markup' => $this->tg->generateKeyboard($this->getKeyboardParams()),
        ]);
    }

    /**
     * @return array
     */
    public function getKeyboardParams(): array
    {
        return [
            'keyboard'        => [
                [
                    ['text' => Phrases::BtnSubscribe->value, 'web_app' => ['url' => Url::to(['/store/subscribe/index'], true)]],
                ]
            ],
            'resize_keyboard' => true
        ];
    }
}