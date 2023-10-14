<?php

namespace app\modules\admin\models;

use Yii;
use \app\modules\admin\models\base\SkipperRating as BaseSkipperRating;

/**
 * This is the model class for table "skipper_rating".
 */
class SkipperRating extends BaseSkipperRating
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['skipper_id', 'user_id', 'ride_id', 'rating', 'status', 'created_on', 'updated_on', 'create_user_id', 'update_user_id'], 'required'],
            [['skipper_id', 'user_id', 'ride_id', 'status', 'create_user_id', 'update_user_id'], 'integer'],
            [['rating'], 'number'],
            [['created_on', 'updated_on'], 'safe']
        ]);
    }
	

}
