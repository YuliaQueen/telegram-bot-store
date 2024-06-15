<?php

namespace app\modules\store\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * @param integer $id
 * @param integer $telegram_id
 * @param string  $name
 * @param string  $email
 * @param integer $is_active
 * @param integer $created_at
 * @param integer $updated_at
 */
class Subscriber extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'subscriber';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'email'], 'required'],
            [['is_active', 'telegram_id'], 'integer'],
            ['is_active', 'default', 'value' => 1],
            [['name', 'email'], 'string', 'max' => 255],
            [['email'], 'email'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'          => Yii::t('app', 'ID'),
            'telegram_id' => Yii::t('app', 'Telegram ID'),
            'name'        => Yii::t('app', 'Имя'),
            'email'       => Yii::t('app', 'Email'),
            'is_active'   => Yii::t('app', 'Активен'),
            'created_at'  => Yii::t('app', 'Создан'),
            'updated_at'  => Yii::t('app', 'Обновлен'),
        ];
    }
}