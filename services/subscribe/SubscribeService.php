<?php

namespace app\services\subscribe;

use app\modules\store\models\Subscriber;
use Exception;
use Yii;
use yii\base\Component;

class SubscribeService extends Component
{
    /**
     * @throws Exception
     */
    public function saveSubscriber($data)
    {
        try {
            $data = json_decode($data, true);
            Yii::error($data, __METHOD__);
            $subscriber = new Subscriber();
            $subscriber->name = $data['name'];
            $subscriber->email = $data['email'];
            if (!$subscriber->save()) {
                throw new Exception(implode(', ', $subscriber->getErrorSummary(true)));
            }
        } catch (Exception $e) {
            Yii::error($e->getMessage(), __METHOD__);
        }
    }
}