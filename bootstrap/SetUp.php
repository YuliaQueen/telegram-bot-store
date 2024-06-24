<?php

namespace app\bootstrap;

use app\services\subscribe\SubscribeService;
use app\services\telegram\TelegramClient;
use app\services\telegram\TelegramClientInterface;
use Yii;
use yii\base\BootstrapInterface;

class SetUp implements BootstrapInterface
{

    /**
     * @inheritDoc
     */
    public function bootstrap($app)
    {
        $container = Yii::$container;

        $container->setSingleton(TelegramClientInterface::class, function () {
            return new TelegramClient();
        });

        $container->setSingleton(SubscribeService::class, function () {
            return new SubscribeService();
        });
    }
}