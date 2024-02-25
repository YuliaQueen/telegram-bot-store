<?php

namespace app\services\telegram\commands;

use Yii;

class DefaultCommand extends BaseCommand
{

    /**
     * @inheritDoc
     */
    public function execute($chatId, $name): void
    {
        $this->tg->sendMessage([
            'chat_id' => $chatId,
            'text'    => Yii::t('app', 'Привет, {name}! Выбери команду в меню ниже', ['name' => $name]),
        ]);
    }
}