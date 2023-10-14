<?php

namespace app\modules\admin\models;

use Yii;
use \app\modules\admin\models\base\RideCompletionLog as BaseRideCompletionLog;

/**
 * This is the model class for table "ride_completion_log".
 */
class RideCompletionLog extends BaseRideCompletionLog
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['ride_id', 'driver_id', 'user_id', 'vehicle_id', 'estimated_price', 'estimated_distance', 'estimated_time', 'final_price', 'final_distance', 'final_time', 'pickup_time', 'pickup_lat', 'pickup_lng', 'drop_time', 'final_drop_lat', 'final_drop_lng', 'couponn_code', 'coupon_applied_id', 'coupon_discount', 'gst_percentage', 'gst', 'service_charge_percentage', 'service_charge', 'payment_method', 'payment_status', 'status', 'created_on', 'updated_on', 'create_user_id', 'update_user_id'], 'required'],
            [['ride_id', 'driver_id', 'user_id', 'vehicle_id', 'coupon_applied_id', 'payment_method', 'payment_status', 'status', 'create_user_id', 'update_user_id'], 'integer'],
            [['estimated_price', 'estimated_distance', 'estimated_time', 'final_price', 'final_distance', 'final_time', 'coupon_discount', 'gst_percentage', 'gst', 'service_charge_percentage', 'service_charge'], 'number'],
            [['pickup_time', 'drop_time', 'created_on', 'updated_on'], 'safe'],
            [['pickup_lat', 'pickup_lng', 'final_drop_lat', 'final_drop_lng', 'couponn_code'], 'string', 'max' => 255]
        ]);
    }
	

}
