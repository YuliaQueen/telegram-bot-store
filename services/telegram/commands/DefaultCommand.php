<?php

namespace app\services\telegram\commands;

use Yii;

class DefaultCommand extends BaseCommand
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
            'chat_id' => $chatId,
            'text'    => Yii::t('app', 'Привет, {name}! Выбери команду в меню ниже', ['name' => $name]),
        ]);
    }
}