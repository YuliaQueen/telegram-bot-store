<?php

namespace app\controllers;

use app\services\telegram\TelegramClientInterface;
use app\services\telegram\TelegramMessageService;
use Telegram\Bot\Exceptions\TelegramSDKException;
use Telegram\Bot\Objects\WebhookInfo;
use Yii;
use yii\base\InvalidConfigException;
use yii\di\NotInstantiableException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\Response;

class TelegramBotController extends Controller
{
    private TelegramClientInterface $tg;
    private TelegramMessageService  $messageService;

    /**
     * @inheritdoc
     * @throws BadRequestHttpException
     */
    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;

        return parent::beforeAction($action);
    }

    /**
     * @inheritdoc
     * @param TelegramMessageService $service
     */
    public function __construct($id, $module, TelegramMessageService $service)
    {
        parent::__construct($id, $module);
        $this->messageService = $service;
    }

    /**
     * @throws NotInstantiableException
     * @throws InvalidConfigException
     */
    public function init()
    {
        parent::init();
        Yii::$app->response->format = Response::FORMAT_JSON;
        $this->tg = Yii::$container->get(TelegramClientInterface::class);
    }

    /**
     * @return void
     */
    public function actionIndex(): void
    {
        $this->messageService->saveMessage($this->tg->getWebhookUpdate());
    }

    public function actionSetWebhook(): bool
    {
        return $this->tg->setWebhook();
    }

    /**
     * @throws TelegramSDKException
     */
    public function actionDeleteWebhook(): bool
    {
        return $this->tg->deleteWebhook();
    }

    /**
     * @throws TelegramSDKException
     */
    public function actionWebhookInfo(): WebhookInfo
    {
        return $this->tg->getWebhookInfo();
    }
}