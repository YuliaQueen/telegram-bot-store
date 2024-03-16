<?php

namespace app\modules\store\controllers;

use Yii;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\View;

class DefaultController extends Controller
{
    /**
     * @inheritdoc
     * @throws BadRequestHttpException
     */
    public function beforeAction($action): bool
    {
        if (parent::beforeAction($action)) {
            if ($this->module->id == 'store') {
                Yii::$app->view->off(View::EVENT_END_BODY);
            }
            return true;
        }
        return false;
    }
}