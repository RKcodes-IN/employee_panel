<?php

namespace app\modules\admin\controllers;

use Yii;
use app\models\User;
use app\modules\admin\models\base\RideCommision;
use app\modules\admin\models\City;
use app\modules\admin\models\Pincode;
use app\modules\admin\models\search\CitySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CityController implements the CRUD actions for City model.
 */
class CityController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'view', 'create', 'update', 'delete', 'update-status', 'add-pincode', 'add-ride-commision'],
                        'matchCallback' => function () {
                            return User::isAdmin() || User::isSubAdmin();
                        }

                    ],
                    [
                        'allow' => true,
                        'actions' => ['index', 'view', 'update', 'pdf', 'update-status'],
                        'matchCallback' => function () {
                            return User::isManager();
                        }
                    ],
                    [
                        'allow' => false
                    ]
                ]
            ]
        ];
    }

    /**
     * Lists all City models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CitySearch();
        if (\Yii::$app->user->identity->user_role == User::ROLE_ADMIN || \Yii::$app->user->identity->user_role == User::ROLE_SUBADMIN) {
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        } else if (\Yii::$app->user->identity->user_role == User::ROLE_MANAGER) {
            $dataProvider = $searchModel->managersearch(Yii::$app->request->queryParams);
        }
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single City model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $providerPincode = new \yii\data\ArrayDataProvider([
            'allModels' => $model->pincodes,
        ]);
        if (!empty($model->rideCommisions)) {
            $providerRideCommision = new \yii\data\ArrayDataProvider([
                'allModels' => $model->rideCommisions,
            ]);
        } else {
            $providerRideCommision = "";
        }

        return $this->render('view', [
            'model' => $this->findModel($id),
            'providerPincode' => $providerPincode,
            'providerRideCommision' => $providerRideCommision,
        ]);
    }

    /**
     * Creates a new City model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new City();

        if ($model->load(Yii::$app->request->post())) {


            if (Yii::$app->request->post('Pincode') && Yii::$app->request->post('RideCommision')) {
                if ($model->save(false)) {
                    $pincodes = Yii::$app->request->post('Pincode');
                    $rideCommisions = Yii::$app->request->post('RideCommision');
                    foreach ($pincodes as $pincode) {
                        // var_dump($pincode["name"]);exit;
                        foreach ($pincode["vehical_id"] as $vehicle) {
                            $pin = new Pincode();
                            $pin->city_id = $model->id;
                            $pin->name = $pincode["name"];
                            $pin->vehical_id = (int)$vehicle;
                            $pin->status = $pincode["status"];
                            $pin->save(false);
                        }
                    }

                    foreach ($rideCommisions as $rideCommision) {
                        // var_dump($pincode["name"]);exit;

                        $rideComm = new RideCommision();
                        $rideComm->city_id = $model->id;
                        $rideComm->vehicle_id = (int)$rideCommision["vehicle_id"];
                        $rideComm->base_fare = $rideCommision["base_fare"];
                        $rideComm->min_distance = $rideCommision["min_distance"];
                        $rideComm->fare_per_distance = $rideCommision["fare_per_distance"];
                        $rideComm->waiting_time_limit = $rideCommision["waiting_time_limit"];
                        $rideComm->charges_per_minute = $rideCommision["charges_per_minute"];
                        $rideComm->no_of_person = $rideCommision["no_of_person"];
                        $rideComm->commision = $rideCommision["commision"];
                        $rideComm->status = $rideCommision["status"];
                        $rideComm->save(false);
                    }
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            } else {
                Yii::$app->session->setFlash('error', "Please add Pincode and Ride Commision sizes");
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing City model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->loadAll(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing City model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {

        $model = $this->findModel($id);
        if (!empty($model)) {
            $model->status = City::STATUS_DELETE;
            $model->save(false);
        }

        return $this->redirect(['index']);
    }

    public function actionUpdateStatus()
    {
        $data = [];
        $post = \Yii::$app->request->post();
        \Yii::$app->response->format = 'json';
        if (!empty($post['id'])) {
            $model = City::find()->where([
                'id' => $post['id'],
            ])->one();
            if (!empty($model)) {

                $model->status = $post['val'];
            }
            if ($model->save(false)) {
                $data['message'] = "Updated";
                $data['id'] = $model->status;
            } else {
                $data['message'] = "Not Updated";
            }
        }
        return $data;
    }


    /**
     * Finds the City model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return City the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = City::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }
    }

    /**
     * Action to load a tabular form grid
     * for Pincode
     * @author Yohanes Candrajaya <moo.tensai@gmail.com>
     * @author Jiwantoro Ndaru <jiwanndaru@gmail.com>
     *
     * @return mixed
     */
    public function actionAddPincode()
    {
        if (Yii::$app->request->isAjax) {
            $row = Yii::$app->request->post('Pincode');
            if (!empty($row)) {
                $row = array_values($row);
            }
            if ((Yii::$app->request->post('isNewRecord') && Yii::$app->request->post('_action') == 'load' && empty($row)) || Yii::$app->request->post('_action') == 'add')
                $row[] = [];
            return $this->renderAjax('_formPincode', ['row' => $row]);
        } else {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }
    }

    /**
     * Action to load a tabular form grid
     * for RideCommision
     * @author Yohanes Candrajaya <moo.tensai@gmail.com>
     * @author Jiwantoro Ndaru <jiwanndaru@gmail.com>
     *
     * @return mixed
     */
    public function actionAddRideCommision()
    {
        if (Yii::$app->request->isAjax) {
            $row = Yii::$app->request->post('RideCommision');
            if (!empty($row)) {
                $row = array_values($row);
            }
            if ((Yii::$app->request->post('isNewRecord') && Yii::$app->request->post('_action') == 'load' && empty($row)) || Yii::$app->request->post('_action') == 'add')
                $row[] = [];
            return $this->renderAjax('_formRideCommision', ['row' => $row]);
        } else {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }
    }
}
