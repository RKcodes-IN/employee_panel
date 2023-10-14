<?php

namespace app\modules\admin\controllers;

use Yii;
use app\models\User;
use app\modules\admin\models\base\RideEarnings;
use app\modules\admin\models\base\RideRequest;
use app\modules\admin\models\SkipperPayout;
use app\modules\admin\models\search\SkipperPayoutSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SkipperPayoutController implements the CRUD actions for SkipperPayout model.
 */
class SkipperPayoutController extends Controller
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
                        'actions' => ['index', 'view', 'create', 'update', 'delete', 'update-status', 'pending-withdraw-request', 'approved-withdraw-request'],
                        'matchCallback' => function () {
                            return User::isAdmin() || User::isSubAdmin();
                        }

                    ],
                    [
                        'allow' => true,
                        'actions' => ['index', 'view', 'update', 'pdf', 'update-status', 'pending-withdraw-request'],
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
     * Lists all SkipperPayout models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SkipperPayoutSearch();
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

    public function actionPendingWithdrawRequest()
    {
        $searchModel = new SkipperPayoutSearch();
        if (\Yii::$app->user->identity->user_role == User::ROLE_ADMIN || \Yii::$app->user->identity->user_role == User::ROLE_SUBADMIN) {
            $dataProvider = $searchModel->withdrawrequestsearch(Yii::$app->request->queryParams, SkipperPayout::STATUS_PROCESSING);
        } else if (\Yii::$app->user->identity->user_role == User::ROLE_MANAGER) {
            $dataProvider = $searchModel->withdrawrequestsearch(Yii::$app->request->queryParams, SkipperPayout::STATUS_PROCESSING);
        }
        return $this->render('withdraw_view', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionApprovedWithdrawRequest()
    {
        $searchModel = new SkipperPayoutSearch();
        if (\Yii::$app->user->identity->user_role == User::ROLE_ADMIN || \Yii::$app->user->identity->user_role == User::ROLE_SUBADMIN) {
            $dataProvider = $searchModel->withdrawrequestsearch(Yii::$app->request->queryParams, SkipperPayout::STATUS_APPROVED);
        } else if (\Yii::$app->user->identity->user_role == User::ROLE_MANAGER) {
            $dataProvider = $searchModel->withdrawrequestsearch(Yii::$app->request->queryParams, SkipperPayout::STATUS_APPROVED);
        }
        return $this->render('withdraw_view', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SkipperPayout model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new SkipperPayout model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $post = Yii::$app->request->post();

        $model = new SkipperPayout();
        if (!empty($post)) {
            if ((int)$post['SkipperPayout']['payment_type'] == SkipperPayout::PAYMENT_TYPE_CREDIT) {
                $model = new RideEarnings();
                $model->driver_id = $post['SkipperPayout']['driver_id'];
                $model->total_amount = $post['SkipperPayout']['amount'];
                $model->driver_earning = $post['SkipperPayout']['amount'];
                $model->refrence_id = $post['SkipperPayout']['refrence_id'];
                $model->method_reason = $post['SkipperPayout']['method_reason'];
                $model->payment_method = RideRequest::PAYMENT_METHOD_ONLINE;
                $model->status = RideEarnings::STATUS_APPROVED;
                $model->type = RideEarnings::MANUL;
                if ($model->save(false)) {
                    return $this->redirect(['ride-earnings/manual-payout', 'id' => $model->id]);
                }
            } else {
                $model = new SkipperPayout();

                if ($model->loadAll(Yii::$app->request->post()) && $model->saveAll()) {
                    return $this->redirect(['index', 'id' => $model->id]);
                } else {
                    return $this->render('create', [
                        'model' => $model,
                    ]);
                }
            }
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing SkipperPayout model.
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
     * Deletes an existing SkipperPayout model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {

        $model = $this->findModel($id);
        if (!empty($model)) {
            $model->status = SkipperPayout::STATUS_DELETE;
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
            $model = SkipperPayout::find()->where([
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
     * Finds the SkipperPayout model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SkipperPayout the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SkipperPayout::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }
    }
}
