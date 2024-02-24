<?php

namespace app\controllers;

use app\models\TelegramMessage;
use app\services\telegram\TelegramClientInterface;
use Exception;
use Telegram\Bot\Exceptions\TelegramSDKException;
use Telegram\Bot\Objects\WebhookInfo;
use Yii;
use yii\base\InvalidConfigException;
use yii\di\NotInstantiableException;
use yii\web\Controller;
use yii\web\Response;

class TelegramBotController extends Controller
{
    private TelegramClientInterface $tg;

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
     * @return array
     */
    public function actionIndex(): array
    {

        try {
            $updates = $this->tg->getUpdates();
            $dbMessages = TelegramMessage::find()->indexBy('update_id')->all();

            foreach ($updates as $update) {
                if (empty($dbMessages[$update['update_id']])) {
                    $tgMessage = new TelegramMessage();
                    $tgMessage->setAttributes(
                        [
                            'update_id'     => $update['update_id'],
                            'chat_id'       => $update['message']['chat']['id'],
                            'chat_type'     => $update['message']['chat']['type'],
                            'message_id'    => $update['message']['message_id'],
                            'text'          => $update['message']['text'],
                            'user_id'       => $update['message']['from']['id'],
                            'is_bot'        => $update['message']['from']['is_bot'],
                            'first_name'    => $update['message']['from']['first_name'],
                            'last_name'     => $update['message']['from']['last_name'],
                            'username'      => $update['message']['from']['username'],
                            'language_code' => $update['message']['from']['language_code'],
                            'is_premium'    => $update['message']['from']['is_premium'],
                            'date'          => $update['message']['date'],
                        ]
                    );
                    if (!$tgMessage->save()) {
                        throw new Exception(Yii::t('app', 'Failed to save message'));
                    }
                }
            }

            return $updates;
        } catch (Exception $e) {
            Yii::error($e->getMessage());
            Yii::$app->session->setFlash('error', $e->getMessage());

            return ['error' => $e->getMessage()];
        }
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