<?php

namespace app\modules\admin\models;

use Yii;
use \app\modules\admin\models\base\OpenMoneyContacts as BaseOpenMoneyContacts;

/**
 * This is the model class for table "open_money_contacts".
 */
class OpenMoneyContacts extends BaseOpenMoneyContacts
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['user_id', 'contacts_id', 'virtual_account_number', 'vpa', 'virtual_account_ifsc', 'status', 'updated_on', 'created_on', 'create_user_id', 'update_user_id'], 'required'],
            [['user_id', 'status', 'create_user_id', 'update_user_id'], 'integer'],
            [['updated_on', 'created_on'], 'safe'],
            [['contacts_id', 'virtual_account_number', 'vpa', 'virtual_account_ifsc'], 'string', 'max' => 255]
        ]);
    }
	

}
