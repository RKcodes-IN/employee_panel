<?php

namespace app\modules\admin\models;

use Yii;
use \app\modules\admin\models\base\Wallet as BaseWallet;

/**
 * This is the model class for table "wallet".
 */
class Wallet extends BaseWallet
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['user_id', 'amount', 'payment_type', 'method_reason', 'created_on', 'updated_on', 'created_user_id', 'updated_user_id'], 'required'],
            [['user_id', 'payment_type', 'type_id', 'status', 'created_user_id', 'updated_user_id'], 'integer'],
            [['amount'], 'number'],
            [['created_on', 'updated_on'], 'safe'],
            [['method_reason'], 'string', 'max' => 255]
        ]);
    }
	

}
