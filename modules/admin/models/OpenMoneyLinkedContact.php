<?php

namespace app\modules\admin\models;

use Yii;
use \app\modules\admin\models\base\OpenMoneyLinkedContact as BaseOpenMoneyLinkedContact;

/**
 * This is the model class for table "open_money_linked_contact".
 */
class OpenMoneyLinkedContact extends BaseOpenMoneyLinkedContact
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['user_id', 'skipper_id', 'map_contacts_id', 'va_account_number', 'va_ifsc', 'vpa', 'commision_type', 'commision', 'status', 'created_on', 'updated_on', 'create_user_id', 'update_user_id'], 'required'],
            [['user_id', 'skipper_id', 'status', 'created_on', 'updated_on'], 'integer'],
            [['create_user_id', 'update_user_id'], 'safe'],
            [['map_contacts_id', 'va_account_number', 'va_ifsc', 'vpa', 'commision_type', 'commision'], 'string', 'max' => 255]
        ]);
    }
	

}
