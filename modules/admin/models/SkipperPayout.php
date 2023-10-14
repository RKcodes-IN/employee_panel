<?php

namespace app\modules\admin\models;

use Yii;
use \app\modules\admin\models\base\SkipperPayout as BaseSkipperPayout;

/**
 * This is the model class for table "skipper_payout".
 */
class SkipperPayout extends BaseSkipperPayout
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['driver_id', 'amount', 'payment_type', 'method_reason',  'status'], 'required'],
            [['driver_id', 'payment_type', 'type_id', 'status', 'create_user_id', 'update_user_id'], 'integer'],
            [['amount'], 'number'],
            [['method_reason', 'created_on', 'updated_on'], 'string', 'max' => 255]
        ]);
    }
	

}
