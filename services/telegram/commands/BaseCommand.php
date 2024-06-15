<?php

namespace app\services\telegram\commands;

use app\services\telegram\TelegramClientInterface;
use Yii;
use yii\base\Component;

abstract class BaseCommand extends Component implements Command
{
    protected TelegramClientInterface $tg;

    public function init()
    {
        parent::init();

        $this->tg = Yii::$container->get(TelegramClientInterface::class);
    }

    /**
     * @inheritDoc
     */
    public abstract function execute(int $chatId, $name, $data = null): void;
}