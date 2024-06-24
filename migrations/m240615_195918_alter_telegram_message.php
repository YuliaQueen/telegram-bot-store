<?php

use yii\db\Migration;

class m240615_195918_alter_telegram_message extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%telegram_message}}', 'contact_phone_number', $this->string(255));
    }

    public function safeDown()
    {
        $this->dropColumn('{{%telegram_message}}', 'contact_phone_number');
    }
}
