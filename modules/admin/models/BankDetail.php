<?php

namespace app\modules\admin\models;

use Yii;
use \app\modules\admin\models\base\BankDetail as BaseBankDetail;

/**
 * This is the model class for table "bank_detail".
 */
class BankDetail extends BaseBankDetail
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['user_id', 'upi_id'], 'required'],
            [['user_id', 'status', 'type_id', 'create_user_id', 'update_user_id'], 'integer'],
            [['created_on', 'updated_on'], 'safe'],
            [['bank_name', 'account_holder_name', 'account_number', 'branch_name', 'ifsc_code'], 'string', 'max' => 127],
            [['upi_id'], 'string', 'max' => 255]
           
        ]);
    }
	

}
?>