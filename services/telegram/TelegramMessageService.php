<?php

namespace app\services\telegram;

use app\models\TelegramMessage;
use Exception;
use Telegram\Bot\Objects\Update;
use Yii;
use yii\base\Component;
use yii\helpers\Json;
use yii\helpers\VarDumper;

class TelegramMessageService extends Component
{
    /**
     * @var TelegramMessage[]
     */
    private array $messages;

    public function init()
    {
        $this->messages = TelegramMessage::find()->indexBy('update_id')->all();

        parent::init();
    }

    /**
     * @param Update $update
     * @return void
     */
    public function saveMessage(Update $update): void
    {
        Yii::error(VarDumper::dumpAsString($update, 20, 1), 'telegram');
        try {
            $tgMessage = new TelegramMessage();
            $tgMessage->setAttributes([
                'update_id'            => $update->updateId ?? null,
                'chat_id'              => $update['message']['chat']['id'] ?? null,
                'chat_type'            => $update['message']['chat']['type'] ?? null,
                'message_id'           => $update['message']['message_id'] ?? null,
                'text'                 => $update['message']['text'] ?? null,
                'user_id'              => $update['message']['from']['id'] ?? null,
                'is_bot'               => $update['message']['from']['is_bot'] ?? null,
                'first_name'           => $update['message']['from']['first_name'] ?? null,
                'last_name'            => $update['message']['from']['last_name'] ?? null,
                'username'             => $update['message']['from']['username'] ?? null,
                'language_code'        => $update['message']['from']['language_code'] ?? null,
                'is_premium'           => $update['message']['from']['is_premium'] ?? null,
                'date'                 => $update['message']['date'] ?? null,
                'contact_phone_number' => $update->message->contact->phoneNumber ?? null,
            ]);

            if (!$tgMessage->save()) {
                Yii::error(VarDumper::dumpAsString($tgMessage->getErrors()), 'telegram_message_save');
            }
        } catch (Exception $e) {
            $message = Json::encode([$e->getMessage(), $update]);
            Yii::error($message, 'telegram_message_save');
        }
    }
}