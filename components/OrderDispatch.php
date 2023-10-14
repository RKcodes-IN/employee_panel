<?php

namespace app\components;

use app\models\User;
use app\modules\admin\models\DriverRequest;
use app\modules\admin\models\GcOrders;
use app\modules\admin\models\Orders;
use app\modules\admin\models\OrderStatus;
use app\modules\admin\models\RideRequest;
use app\modules\admin\models\WebSetting;
use Yii;
use yii\base\Component;

class OrderDispatch extends Component
{

    public function assignAuto()
    {
        $setting = new WebSetting();
        $auto_dispatch_type = $setting->getSettingBykey('auto_dispatch_type');
        $auto_dispatch_radius = $setting->getSettingBykey('auto_dispatch_radius');
        // $auto_dispatch_no_of_drivers = $setting->getSettingBykey('auto_dispatch_no_of_drivers');

        $get = Yii::$app->request->get();
        // var_dump($get);exit;
        $id = $get['ride_id'];
        if (!empty($get)) {
            $getOrder = RideRequest::find()
                ->Where(['id' => (int)$get['ride_id']])
                ->andWhere(['!=', 'status', RideRequest::STATUS_RIDE_COMPLETED])

                // echo $getOrder->createCommand()->getRawSql();exit;

                ->one();
            // print_r($getOrder);exit;

            if (!empty($getOrder)) {

                $source_lat = $getOrder->pickup_latitude; //$post['source_lat'];
                $source_lng = $getOrder->pickup_longitude; //$post['source_lng'];
                //near by Drivers $pickup_lat =  $rideRequest->pickup_latitude;
                // $pickup_lng =  $rideRequest->pickup_longitude;
                // var_dump($source_lat);
                // var_dump($source_lng);
                // exit;
                $multiplyFactor = '111.1111';
                $distanceQuery = "(" . $multiplyFactor . " *
                DEGREES(ACOS(LEAST(1.0, COS(RADIANS(user.lat))
                * COS(RADIANS(" . $source_lat . "))
                * COS(RADIANS(user.lng) - RADIANS(" . $source_lng . "))
                + SIN(RADIANS(user.lat))
                * SIN(RADIANS(" . $source_lat . "))))))";

                $nearby_drivers = User::find()
                    ->joinWith('driverDetails as dd')
                    ->select('user.*,' . $distanceQuery . ' as distance,
                (SELECT COUNT(o.id) FROM ride_request o) as rides_count')
                    ->where('user.lat')
                    ->andWhere(['<', $distanceQuery, 10])
                    ->andWhere('user.lng')
                    ->andWhere(['user_role' => User::ROLE_SKIPPER])
                    ->andWhere(['dd.vehical_id' => $getOrder->vehical_type])
                    ->all();


                // var_dump($nearby_drivers);exit;
                // echo $query->createCommand()->getRawSql();
                // exit;


                //     $nearby_drivers = User::find()
                //         ->joinWith('driverDetails as dd')

                //         ->select("*,	(6371 * acos( cos( radians({$source_lat})) *
                // cos( radians('lat') ) * cos( radians('lng') - radians({$source_lng}) ) +
                // sin( radians({$source_lat}) ) * sin( radians('lat') ) ) ) AS distance")->having("distance <:distance")->addParams([
                //             ':distance' => 9000, //distance kms
                //         ])

                //         ->Where(['user.user_role' => User::ROLE_SKIPPER])
                //         ->andWhere(['user.online_status' => User::ONLINE, 'user.status' => User::STATUS_ACTIVE])
                //         ->andWhere(['dd.vehical_id' => $getOrder->vehical_type])
                //         ->orderBy([
                //             'distance' => SORT_ASC, //specify sort order ASC for ascending DESC for descending
                //         ])->all();
                // echo $nearby_drivers->createCommand()->getRawSql(); exit;

                // var_dump($nearby_drivers);
                // exit;

                //make dynamic from settings
                if (!empty($nearby_drivers)) {
                    //Check which Delivery Assign type
                    switch (2) {

                        case 1:
                            $assigned = Yii::$app->orderDispatch->assignOne($nearby_drivers, $id);

                            if ($assigned['status'] == 'NOK') {
                                $data['status'] = 'NOK';
                                $data['error'] =  $assigned['accept_state'];
                            } else {
                                $data['status'] = 'OK';
                                $data['msg'] = 'Order Assigned';
                            }
                            break;
                        case 2:
                            $assigned = Yii::$app->orderDispatch->assignAll($nearby_drivers, $id);
                            if ($assigned['status'] == 'NOK') {
                                $data['status'] = 'NOK';
                                $data['error'] = $assigned['accept_state'];
                            } else {
                                $data['status'] = 'OK';
                                $data['msg'] = $assigned['accept_state'];
                            }
                            break;
                        case 3:
                            $assigned = Yii::$app->orderDispatch->assignNearby($nearby_drivers, $id);
                            if ($assigned['status'] == 'NOK') {
                                $data['status'] = 'NOK';
                                $data['error'] = 'Order Assigning failed';
                            } else {
                                $data['status'] = 'OK';
                                $data['msg'] = 'Order Assigned to Nearby driver! Waiting for Accept';
                            }
                            break;

                        default:
                            $assigned = Yii::$app->orderDispatch->assignOne($nearby_drivers, $id);
                            if ($assigned['status'] == 'NOK') {
                                $data['status'] = 'NOK';
                                $data['error'] = 'Order Assigning failed';
                            } else {
                                $data['status'] = 'OK';
                                $data['msg'] = 'Order Assigned';
                            }
                            break;
                    }
                } else {
                    $data['status'] = 'NOK';
                    $data['error'] = 'No Nearby drivers found';
                }
            } else {
                $data['status'] = 'NOK';
                $data['error'] = 'No Order found';
            }
        } else {
            $data['status'] = 'NOK';
            $data['error'] = 'No data Posted';
        }
        return $data;
    }

    //Assigning One by One

    public function assignOne($nearby_drivers, $id)
    {

        $setting = new WebSetting();
        $auto_dispatch_wait_time = $setting->getSettingBykey('auto_dispatch_wait_time');
        $data = [];

        $i = 0;
        foreach ($nearby_drivers as $nearby_driver) {

            //Check order Accepted or Not
            $check_accept = DriverRequest::find()->Where([
                'ride_id' => $id,
                'status' => DriverRequest::RIDE_ACCEPT
            ])->one();
            if (empty($check_accept)) {

                // var_dump($nearby_driver);exit;
                $driver_request = new DriverRequest();
                $driver_request->ride_id = $id;
                $driver_request->driver_id = $nearby_driver['id'];
                $driver_request->status = DriverRequest::RIDE_ASSIGNED;
                $driver_request->updated_on = date('Y-m-d H:i:s');
                $driver_request->created_on = date('Y-m-d H:i:s');
                if ($driver_request->save()) {

                    $title = 'New Order #' . $id . ' assigned';
                    $body = 'New Order Request';
                    $send_noti = Yii::$app->notification->DriverNotification($id, $driver_request->driver_id, $title, $body);
                    sleep(isset($auto_dispatch_wait_time) ? $auto_dispatch_wait_time : 30);

                    // Check Status of Accept

                    $check = $driver_request->find()->Where(['id' => $driver_request->id, 'driver_id' => $driver_request->driver_id])->one();

                    if ($check->status == DriverRequest::RIDE_ACCEPT) {

                        $data['status'] = "OK";
                        $data['details'] = $check;
                        // $data['notification'] =  $send_noti;
                        break;
                    } else if ($check->status == DriverRequest::RIDE_REJECT) {
                        $data['status'] = "OK";
                        $data['details'] = $check;
                        //  $data['notification'] =  $send_noti;

                    } else {

                        $check->status = DriverRequest::RIDE_CANCELLED;
                        $check->updated_on = date('Y-m-d H:i:s');
                        if ($check->update(false)) {
                            $data['status'] = "NOK";
                            $data['details'] = $check;
                            $data['accept_state'] = "No Driver accepted your Order.Please contact Admin to assign Order manually to Delivery Driver";
                            //   $data['notification'] =  $send_noti;
                        }
                    }
                } else {
                    $data['status'] = "NOK";
                    $data['details'] = $driver_request;
                }

                //$data['notification'] = $send_noti;
            } else {
                $data['status'] = "NOK";
                $data['details'] = "Order already Accepted";
                $data['accept_state'] = "Order already Accepted";
            }
        }
        return $data;
    }

    //Assigning All Availble Drivers at once

    public function assignAll($nearby_drivers, $id)
    {

        $setting = new WebSetting();
        $auto_dispatch_wait_time = $setting->getSettingBykey('auto_dispatch_wait_time');
        $data = [];

        $i = 0;
        foreach ($nearby_drivers as $nearby_driver) {

            //Check order Accepted or Not
            $checkAlredyAssigned = DriverRequest::find()->where(
                [
                    'ride_id' => $id,
                    'driver_id' => $nearby_driver['id']
                ]
            )->one();

            $check_accept = DriverRequest::find()->Where([
                'ride_id' => $id,
                'status' => DriverRequest::RIDE_ACCEPT
            ])->one();
            if (empty($checkAlredyAssigned)) {
                if (empty($check_accept)) {

                    // var_dump($nearby_driver);exit;
                    $driver_request = new DriverRequest();
                    $driver_request->ride_id = $id;
                    $driver_request->driver_id = $nearby_driver['id'];
                    $driver_request->status = DriverRequest::RIDE_ASSIGNED;
                    $driver_request->updated_on = date('Y-m-d H:i:s');
                    $driver_request->created_on = date('Y-m-d H:i:s');
                    if ($driver_request->save(false)) {
                        // $orderStatus = new OrderStatus();
                        // $orderStatus->order_id = $id;
                        // $orderStatus->driver_id = $nearby_drivers[0]['id'];
                        // $orderStatus->status = DriverRequest::STATUS_NEW_REQUEST;
                        // $orderStatus->remarks = "New Order of ID# " .$id . " assigned to Driver id# " . $nearby_drivers[0]['id'] . ' at ' . date('Y-m-d H:i:s');
                        // $orderStatus->save(false);
                        //   $title = 'New Order #' . $id . ' assigned';
                        //   $body = 'New Order Request';
                        //   $send_noti = Yii::$app->notification->driverNotification($id,$driver_request->driver_id,$title,$body,'newOrder' );



                    } else {
                        $data['status'] = "NOK";
                        $data['details'] = $driver_request;
                        $data['accept_state'] = "failed to save request";
                    }
                    // Check Status of Accept code at Accepting Order API
                    $data['status'] = "OK";
                    $data['details'] = $driver_request;
                    $data['accept_state'] = "Ride Assigned to all Drivers";
                    //$data['notification'] = $send_noti;
                } else {
                    $data['status'] = "NOK";
                    $data['details'] = "Ride already Accepted";
                    $data['accept_state'] = "Ride already Accepted";
                }
            }else{
                $data['status'] = "NOK";
                $data['details'] = "All nearby skippers already assigned to this ride id";
                $data['accept_state'] = "All nearby skippers already assigned to this ride id";
            }
        }


        return $data;
    }

    //    //Assigning Nearby One driver

    public function assignNearby($nearby_drivers, $id)
    {

        $setting = new WebSetting();
        $auto_dispatch_wait_time = $setting->getSettingBykey('auto_dispatch_wait_time');
        $data = [];

        $i = 0;

        //Check order Accepted or Not
        $check_accept = DriverRequest::find()
            ->Where([
                'ride_id' => $id,
                'status' => DriverRequest::RIDE_ACCEPT
            ])->one();
        if (empty($check_accept)) {

            // var_dump($nearby_driver);exit;
            $driver_request = new DriverRequest();
            $driver_request->ride_id = $id;
            $driver_request->driver_id = $nearby_drivers[0]['id'];
            $driver_request->status = DriverRequest::RIDE_ASSIGNED;
            $driver_request->updated_on = date('Y-m-d H:i:s');
            $driver_request->created_on = date('Y-m-d H:i:s');
            if ($driver_request->save(false)) {
                // $orderStatus = new OrderStatus();
                // $orderStatus->order_id = $id;
                // $orderStatus->driver_id = $nearby_drivers[0]['id'];
                // $orderStatus->status = DriverRequest::STATUS_NEW_REQUEST;
                // $orderStatus->remarks = "New Order of ID# " . $id . " assigned to Driver id# " . $nearby_drivers[0]['id'] . ' at ' . date('Y-m-d H:i:s');
                // $orderStatus->save(false);
                // $title = 'New Order #' . $id . ' assigned';
                // $body = 'New Order Request';
                // if (isset($title)) {

                //     $send_noti = Yii::$app->notification->driverNotification($id, $driver_request->driver_id, $title, $body, 'newOrder');
                // }
                // //   $send_noti = Yii::$app->notification->driverNotification($id,$driver_request->driver_id,$title,$body );
                // $data['status'] = "OK";
                // $data['details'] = $driver_request;
                // print_r($send_noti);exit;

            } else {
                $data['status'] = "NOK";
                $data['details'] = $driver_request;
            }

            //$data['notification'] = $send_noti;
        } else {
            $data['status'] = "NOK";
            $data['details'] = "Order already Accepted";
        }

        return $data;
    }
}
