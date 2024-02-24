<?php

use yii\db\Migration;

class m240224_193532_create_telegram_message extends Migration
{
    public function safeUp()
    {
        $this->createTable('telegram_message', [
            'id'            => $this->primaryKey(),
            'update_id'     => $this->integer(),
            'chat_id'       => $this->integer(),
            'chat_type'     => $this->string(),
            'message_id'    => $this->integer(),
            'text'          => $this->text(),
            'user_id'       => $this->integer(),
            'is_bot'        => $this->boolean(),
            'first_name'    => $this->string(),
            'last_name'     => $this->string(),
            'username'      => $this->string(),
            'language_code' => $this->string(),
            'is_premium'    => $this->boolean(),
            'date'          => $this->integer(),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('telegram_message');
    }
}
