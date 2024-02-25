<?php

namespace app\services\telegram\commands;

use Yii;

class HelpCommand extends BaseCommand
{
    /**
     * @inheritDoc
     */
    public function execute($chatId, $name): void
    {
        $this->tg->sendMessage([
            'chat_id' => $chatId,
            'text'    => Yii::t('app', 'Привет, {name}! Здесь вы можете получить помощь', ['name' => $name]),
        ]);
    }
}
