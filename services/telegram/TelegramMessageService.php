<?php

namespace app\services\telegram;

use app\models\TelegramMessage;
use Exception;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Objects\Update;
use Yii;
use yii\base\Component;
use yii\helpers\Json;

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
        try {
            if (empty($this->messages[$update['update_id']])) {
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
        } catch (Exception $e) {
            $message = Json::encode([$e->getMessage(), $update]);
            Yii::error($message, 'telegram_message_save');
        }
    }
}