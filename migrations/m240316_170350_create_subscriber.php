<?php

use yii\db\Migration;

class m240316_170350_create_subscriber extends Migration
{
    public function safeUp()
    {
        $this->createTable('subscriber', [
            'id'          => $this->primaryKey(),
            'telegram_id' => $this->integer(),
            'name'        => $this->string(),
            'email'       => $this->string(),
            'is_active'   => $this->boolean()->notNull()->defaultValue(1),
            'created_at'  => $this->integer(),
            'updated_at'  => $this->integer(),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('subscriber');
    }
}
