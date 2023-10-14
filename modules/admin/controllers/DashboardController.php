<?php

namespace app\modules\admin\controllers;
use yii;
use app\models\User;
use app\modules\admin\models\RideEarnings;
use app\modules\admin\models\RideRequest;

class DashboardController extends Controller
{
	/**
	 * @inheritdoc
	 */
	public function actions()
	{
		return [
			'error'   => [
				'class' => 'yii\web\ErrorAction',
			],
		];
	}

	/**
	 * Displays dashboard with some statistics.
	 *
	 * @return string
	 */
	public function actionIndex()
	{

	$total_users = User::find()->where(['status' => User::STATUS_ACTIVE])->andWhere(['user_role' => User::ROLE_USER])->count();
	$total_skippers = User::find()->where(['status' => User::STATUS_ACTIVE])->andWhere(['user_role' => User::ROLE_SKIPPER])->count();
	$total_ride_request = RideRequest::find()->count();
	$new_ride_request = RideRequest::find()->where(['status'=>RideRequest::STATUS_NEW_REQUEST])->count();
	$total_completed_rides = RideRequest::find()->where(['status'=>RideRequest::STATUS_RIDE_COMPLETED_PAID])->count();
	$total_earnings = RideEarnings::find()->sum('admin_earning');
		return $this->render('index',['total_users' => $total_users,
		'total_users' => $total_users,
		'total_skippers' => $total_skippers,
		'total_ride_request' => $total_ride_request,
		'new_ride_request' => $new_ride_request,
		'total_completed_rides' => $total_completed_rides,
		'total_earnings' => $total_earnings,


		]);
	}
}