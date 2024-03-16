<?php

namespace app\assets;

use yii\web\AssetBundle;

class TelegramWebAppAsset extends AssetBundle
{
    public $css = [];
    public $js = [
        'js/telegram-web-app.js',
    ];
    public $depends = [];
}
