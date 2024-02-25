<?php

namespace app\controllers;

use app\enums\Phrases;
use app\enums\TelegramCommands;
use app\services\telegram\TelegramClient;
use app\services\telegram\TelegramClientInterface;
use app\services\telegram\TelegramMessageService;
use Telegram\Bot\Exceptions\TelegramSDKException;
use Telegram\Bot\Objects\WebhookInfo;
use Yii;
use yii\base\InvalidConfigException;
use yii\di\NotInstantiableException;
use yii\helpers\Url;
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

        $text = $update['message']['text'] ?? null;
        $chatId = $update['message']['chat']['id'];
        $name = $update['message']['from']['first_name'];

        if (empty($text)) {
            $this->sendDefaultMessage($chatId, $name);
            return;
        }

        $keyboardParams = $this->getKeyboardParams();
        $inlineKeyboardParams = $this->getInlineKeyboardParams();

        switch ($text) {
            case TelegramCommands::START->value:
                $this->tg->sendMessage([
                    'chat_id'      => $chatId,
                    'text'         => Yii::t('app', 'Привет, {name}!', ['name' => $name]),
                    'parse_mode'   => TelegramClient::PARSE_MODE_HTML,
                    'reply_markup' => $this->messageService->generateKeyboard($keyboardParams),
                ]);
                break;
            case TelegramCommands::HELP->value:
                $this->tg->sendMessage([
                    'chat_id'    => $chatId,
                    'text'       => Yii::t('app', 'Напиши сообщение'),
                    'parse_mode' => TelegramClient::PARSE_MODE_HTML,
                ]);
                break;

            case TelegramCommands::STORE->value:
                $this->tg->sendMessage([
                    'chat_id'      => $chatId,
                    'text'         => Yii::t('app', 'Открыть магазин'),
                    'parse_mode'   => TelegramClient::PARSE_MODE_HTML,
                    'reply_markup' => $this->messageService->generateKeyboard($inlineKeyboardParams),
                ]);
                break;
            default:
                $this->sendDefaultMessage($chatId, $name);
                break;
        }

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
    private function getKeyboardParams(): array
    {
        return [
            'keyboard'        => [
                [
                    ['text' => Phrases::BtnSubscribe->value, 'web_app' => ['url' => Url::to(['subscribe/index'], true)]],
                ]
            ],
            'resize_keyboard' => true
        ];
    }

    private function getInlineKeyboardParams()
    {
        return [
            'inline_keyboard' => [
                [
                    ['text' => Phrases::BtnOpenStore->value, 'web_app' => ['url' => Url::to(['store/index'], true)]],
                ]
            ]
        ];
    }

    /**
     * @param $chatId
     * @param $name
     * @return void
     */
    private function sendDefaultMessage($chatId, $name): void
    {
        $this->tg->sendMessage([
            'chat_id' => $chatId,
            'text'    => Yii::t('app', 'Привет, {name}! Выбери команду в меню ниже', ['name' => $name]),
        ]);
    }
}