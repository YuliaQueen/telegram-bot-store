<?php

namespace app\controllers;

use app\enums\TelegramCommands;
use app\services\telegram\commands\Command;
use app\services\telegram\commands\DefaultCommand;
use app\services\telegram\commands\HelpCommand;
use app\services\telegram\commands\StartCommand;
use app\services\telegram\commands\StoreCommand;
use app\services\telegram\commands\WebAppDataCommand;
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
        $update = $this->tg->getWebhookUpdate();

        $text   = $update['message']['text'] ?? null;
        $chatId = $update['message']['chat']['id'];
        $name   = $update['message']['from']['first_name'];
        $data   = $update['message']['web_app_data']['data'] ?? null;

        $commands = $this->getCommands();

        if ($data) {
            $commands[TelegramCommands::WEB_APP_DATA->value]->execute($chatId, $name, $data);
            return;
        }

        if (empty($text)) {
            $commands[TelegramCommands::DEFAULT->value]->execute($chatId, $name);
            return;
        }

        /** @var Command $command */
        $command = $commands[$text] ?? $commands[TelegramCommands::DEFAULT->value];

        $command->execute($chatId, $name);

        $this->messageService->saveMessage($update);
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

    /**
     * @return array
     */
    private function getCommands(): array
    {
        return [
            TelegramCommands::START->value        => new StartCommand(),
            TelegramCommands::HELP->value         => new HelpCommand(),
            TelegramCommands::STORE->value        => new StoreCommand(),
            TelegramCommands::DEFAULT->value      => new DefaultCommand(),
            TelegramCommands::WEB_APP_DATA->value => new WebAppDataCommand(),
        ];
    }
}