<?php

namespace app\controllers;

use yii\web\Controller;

class SubscribeController extends Controller
{
    /**
     * @return string
     */
    public function actionIndex()
    {
        return $this->renderPartial('index');
    }
}