<?php

namespace app\modules\admin\models;

use Yii;
use \app\modules\admin\models\base\FcmNotification as BaseFcmNotification;

/**
 * This is the model class for table "fcm_notification".
 */
class FcmNotification extends BaseFcmNotification
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['title', 'user_id', 'description', 'image_url', 'status', 'created_date'], 'required'],
            [['user_id', 'status'], 'integer'],
            [['title', 'description', 'url', 'image_url', 'created_date'], 'string', 'max' => 255]
        ]);
    }
	

}
