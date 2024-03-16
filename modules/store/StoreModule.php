<?php

namespace app\modules\store;

use yii\base\Module;

class StoreModule extends Module
{
    public $controllerNamespace = 'app\modules\store\controllers';
    public $layout = 'main';

    public function init()
    {
        parent::init();
    }
}