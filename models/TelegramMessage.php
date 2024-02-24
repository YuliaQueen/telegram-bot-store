<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * @property int    $id
 * @property int    $update_id
 * @property int    $chat_id
 * @property string $chat_type
 * @property int    $message_id
 * @property string $text
 * @property int    $user_id
 * @property bool   $is_bot
 * @property string $first_name
 * @property string $last_name
 * @property string $username
 * @property string $language_code
 * @property bool   $is_premium
 * @property int    $date
 */
class TelegramMessage extends ActiveRecord
{

    public static function tableName()
    {
        return 'telegram_message';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[
                'update_id', 'chat_id', 'message_id', 'user_id', 'date'
            ], 'integer'],
            [[
                'chat_type', 'text', 'first_name', 'last_name', 'username',
                'language_code'
            ], 'string'],
            [[
                'is_bot', 'is_premium'
            ], 'boolean'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'update_id'     => 'Update ID',
            'chat_id'       => 'Chat ID',
            'chat_type'     => 'Chat Type',
            'message_id'    => 'Message ID',
            'text'          => 'Text',
            'user_id'       => 'User ID',
            'is_bot'        => 'Is Bot',
            'first_name'    => 'First Name',
            'last_name'     => 'Last Name',
            'username'      => 'Username',
            'language_code' => 'Language Code',
            'is_premium'    => 'Is Premium',
            'date'          => 'Date',
        ];
    }
}