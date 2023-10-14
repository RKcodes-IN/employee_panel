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

		return $this->render('index');
	}
}