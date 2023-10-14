<?php

namespace app\modules\admin\models;

use Yii;
use \app\modules\admin\models\base\RideEarnings as BaseRideEarnings;

/**
 * This is the model class for table "ride_earnings".
 */
class RideEarnings extends BaseRideEarnings
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['ride_id', 'driver_id', 'total_ditance_km', 'admin_earning', 'driver_earning', 'status', 'created_on', 'updated_on', 'update_user_id'], 'required'],
            [['ride_id', 'driver_id', 'status', 'create_user_id', 'update_user_id'], 'integer'],
            [['total_ditance_km', 'admin_earning', 'driver_earning'], 'number'],
            [['created_on', 'updated_on'], 'safe']
        ]);
    }
	

}
