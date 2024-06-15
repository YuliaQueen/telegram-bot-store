<?php

namespace app\services\telegram\commands;

use Yii;

class HelpCommand extends BaseCommand
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
            'text'    => Yii::t('app', 'Привет, {name}! Здесь вы можете получить помощь', ['name' => $name]),
        ]);
    }
}
