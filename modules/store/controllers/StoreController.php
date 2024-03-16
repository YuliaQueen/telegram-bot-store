<?php

namespace app\modules\store\controllers;

class StoreController extends DefaultController
{
    /**
     * @return string
     */
    public function actionIndex(): string
    {
        return $this->render('index');
    }
}