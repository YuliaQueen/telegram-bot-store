<?php

/** @var yii\web\View $this */

/** @var app\modules\store\models\Subscriber $subscriber */

use yii\widgets\ActiveForm;

$this->title = Yii::t('app', 'Подписаться на новости и акции');

$this->registerJs("
const mainButton = tg.MainButton;
mainButton.setParams({
    'text': 'Отправить форму',
    'color': '#FF0000',
    'textColor': 'white',
});
mainButton.show();

tg.onEvent('mainButtonClicked', () => {
    tg.sendData(JSON.stringify({
        'name': document.getElementsByName('name')[0].value,
        'email': document.getElementsByName('email')[0].value
    }));
})
");
?>

    <h4><?php
        echo $this->title; ?></h4>
<?php
$form = ActiveForm::begin([
    'id'                     => 'subscribe-form',
    'enableAjaxValidation'   => false,
    'enableClientValidation' => true,
    'validateOnBlur'         => true,
]); ?>
    <div class="mb-3">
        <?php
        echo $form->field($subscriber, 'name')->textInput([
            'name'        => 'name',
            'class'       => 'form-control',
            'placeholder' => Yii::t('app', 'Введите ваше имя'),
            'label'       => false
        ]); ?>
    </div>
    <div class="mb-3">
        <?php
        echo $form->field($subscriber, 'email')->textInput([
            'name'        => 'email',
            'autofocus'   => true,
            'class'       => 'form-control',
            'placeholder' => Yii::t('app', 'Введите ваш Email'),
            'label'       => false
        ]); ?>
    </div>
<?php
ActiveForm::end(); ?>