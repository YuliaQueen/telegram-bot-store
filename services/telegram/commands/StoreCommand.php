<?php

namespace app\services\telegram\commands;

use app\enums\Phrases;
use app\services\telegram\TelegramClient;
use Yii;
use yii\helpers\Url;

class StoreCommand extends BaseCommand
{
    /**
     * @inheritDoc
     */
    public function execute($chatId, $name): void
    {
        $this->tg->sendMessage([
            'chat_id'      => $chatId,
            'text'         => Yii::t('app', 'Открыть магазин'),
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
            'inline_keyboard' => [
                [
                    ['text' => Phrases::BtnOpenStore->value, 'web_app' => ['url' => Url::to(['/store/store/index'], true)]],
                ]
            ]
        ];
    }
}