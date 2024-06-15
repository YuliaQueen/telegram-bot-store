<?php

namespace app\services\telegram\commands;

use app\services\subscribe\SubscribeService;
use Yii;

class WebAppDataCommand extends BaseCommand
{
    public SubscribeService $subscribeService;

    public function init()
    {
        parent::init();
        $this->subscribeService = Yii::$container->get(SubscribeService::class);
    }

    /**
     * @inheritDoc
     */
    public function execute($chatId, $name, $data = null): void
    {
        try {
            if (empty($data)) {
                throw new \Exception('Empty web app data');
            }

            $this->subscribeService->saveSubscriber($data);

            $this->tg->sendMessage([
                'chat_id' => $chatId,
                'text'    => Yii::t('app', 'Спасибо за подписку'),
            ]);
        } catch (\Exception $e) {
            Yii::error($e->getMessage(), __METHOD__);

            $this->tg->sendMessage([
                'chat_id' => $chatId,
                'text'    => Yii::t('app', 'Не получилось обработать запрос'),
            ]);
        }
    }
}