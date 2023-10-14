<?php

namespace app\modules\admin\models;

use Yii;
use \app\modules\admin\models\base\Coupon as BaseCoupon;

/**
 * This is the model class for table "coupon".
 */
class Coupon extends BaseCoupon
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['name', 'code', 'discount', 'max_discount', ], 'required'],
            [['description'], 'string'],
            [['min_ride_amount'], 'number'],
            [['max_use', 'max_use_of_coupon', 'status', 'type_id', 'create_user_id', 'update_user_id'], 'integer'],
            [['start_date', 'end_date', 'created_on', 'updated_on'], 'safe'],
            [['name', 'code', 'discount', 'max_discount'], 'string', 'max' => 255],
            [['is_global'], 'string', 'max' => 1]
        ]);
    }
	

}
