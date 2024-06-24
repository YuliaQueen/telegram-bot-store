<?php

namespace app\modules\store\controllers;

use app\modules\store\models\Subscriber;
use Yii;

class SubscribeController extends DefaultController
{
    public Subscriber $subscriber;

    /**
     * @inheritDoc
     */
    public function beforeAction($action): bool
    {
        if (!parent::beforeAction($action)) {
            return false;
        }

        if ($subscriberId = Yii::$app->request->get('id')) {
            $this->subscriber = Subscriber::findOne($subscriberId);
            
            if (!$this->subscriber) {
                return false;
            }
        }

        return true;
    }

    /**
     * @return string
     */
    public function actionIndex()
    {
        $this->subscriber = new Subscriber();

        return $this->render('index', [
            'subscriber' => $this->subscriber
        ]);
    }
}