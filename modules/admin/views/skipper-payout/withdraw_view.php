<?php

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\search\SkipperPayoutSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

use yii\helpers\Html;
use kartik\export\ExportMenu;
use app\models\User;
use app\modules\admin\models\base\BankDetail;
use app\modules\admin\models\base\Banner;
use app\modules\admin\models\SkipperPayout;
use kartik\grid\GridView;

$this->title = Yii::t('app', 'Skipper Payouts');
$this->params['breadcrumbs'][] = $this->title;
$search = "$('.search-button').click(function(){
	$('.search-form').toggle(1000);
	return false;
});";
$this->registerJs($search);


?>
<div class="skipper-payout-index">
    <div class="card">
        <div class="card-body">

            <?php // echo $this->render('_search', ['model' => $searchModel]); 
            ?>

            <p>
                <?php if (\Yii::$app->user->identity->user_role == User::ROLE_ADMIN || \Yii::$app->user->identity->user_role == User::ROLE_SUBADMIN) { ?>
                    <?= Html::a(Yii::t('app', 'Create Skipper Payout'), ['create'], ['class' => 'btn btn-success']) ?>
                <?php  } ?>
                <?= Html::a(Yii::t('app', 'Advance Search'), '#', ['class' => 'btn btn-info search-button']) ?>
            </p>
            <div class="search-form" style="display:none">
                <?= $this->render('_search', ['model' => $searchModel]); ?>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <?php
            $gridColumn = [
                ['class' => 'yii\grid\SerialColumn'],

                ['attribute' => 'id', 'visible' => false],

                [
                    'attribute' => 'benifecery_name',
                    'format' => 'raw',
                    'value' => function ($model) {
                        $bankDetails = BankDetail::find()->where(['user_id' => $model->driver_id])->one();
                        return $bankDetails->account_holder_name;
                    },


                ],


                [
                    'attribute' => 'beneficiary_account_number ',
                    'label' => 'Beneficiary Account Number',
                    'format' => 'raw',
                    'value' => function ($model) {
                        $bankDetails = BankDetail::find()->where(['user_id' => $model->driver_id])->one();
                        return $bankDetails->account_number;
                    },


                ],

                [
                    'attribute' => 'ifsc_code ',
                    'format' => 'raw',
                    'value' => function ($model) {
                        $bankDetails = BankDetail::find()->where(['user_id' => $model->driver_id])->one();
                        return $bankDetails->ifsc_code;
                    },


                ],

                'method_reason',
                'amount',
                // [
                //     'attribute' => 'ifsc_code ',
                //     'format' => 'raw',
                //     'value' => function ($model) {
                //         $bankDetails = BankDetail::find()->where(['user_id' => $model->driver_id])->one();
                //         return $bankDetails->ifsc_code;
                //     },


                // ],



                [
                    'attribute' => 'status',
                    'filter'  => (new SkipperPayout)->getStateOptions(),
                    "format" => 'raw',
                    'value' => function ($data) {
                        if ($data->status != SkipperPayout::STATUS_APPROVED) {
                            $html = '';

                            $html .= '<select class="form-control"  id="status_list_' . $data->id . '" data-id="' . $data->id . '" >';
                            $lists = $data->getStateOptions();

                            foreach ($lists as $key => $list) {

                                if ($key == $data->status) {
                                    $html .= '<option value="' . $key . '" class="form-control" selected>' . $list . '</option>';
                                } else {
                                    $html .= '<option value="' . $key . '" class="form-control">' . $list . '</option>';
                                }
                            }
                            $html .= '</select>';

                            return $html;
                        } else {
                            return $data->getStateOptionsBadges();
                        }
                    },

                ],


                [
                    'class' => 'kartik\grid\ActionColumn',
                    'template' => '{view} ',
                    'buttons' => [
                        'view' => function ($url, $model) {
                            if (\Yii::$app->user->identity->user_role == User::ROLE_ADMIN || \Yii::$app->user->identity->user_role == User::ROLE_SUBADMIN || \Yii::$app->user->identity->user_role == User::ROLE_MANAGER) {
                                return Html::a('<span class="fas fa-eye" aria-hidden="true"></span>', $url);
                            }
                        },
                        'update' => function ($url, $model) {
                            if (\Yii::$app->user->identity->user_role == User::ROLE_ADMIN || \Yii::$app->user->identity->user_role == User::ROLE_SUBADMIN || \Yii::$app->user->identity->user_role == User::ROLE_MANAGER) {
                                return Html::a('<span class="fas fa-pencil-alt" aria-hidden="true"></span>', $url);
                            }
                        },
                        'delete' => function ($url, $model) {
                            if (\Yii::$app->user->identity->user_role == User::ROLE_ADMIN || \Yii::$app->user->identity->user_role == User::ROLE_SUBADMIN) {
                                return Html::a('<span class="fas fa-trash-alt" aria-hidden="true"></span>', $url, [
                                    'data' => [
                                        'method' => 'post',
                                        // use it if you want to confirm the action
                                        'confirm' => 'Are you sure?',
                                    ],
                                ]);
                            }
                        },


                    ]



                ],
            ];
            ?>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => $gridColumn,
                'bordered' => false,
                'class' => 'table table-striped mb-0',
                'pjax' => true,
                'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-skipper-payout']],
                'panel' => [
                    'type' => 'light',
                    'heading' => '<span class="glyphicon glyphicon-book"></span>  ' . Html::encode($this->title),
                ],
                'export' => false,
                // your toolbar can include the additional full export menu
                'toolbar' => [
                    '{export}',
                    ExportMenu::widget([
                        'dataProvider' => $dataProvider,
                        'columns' => $gridColumn,
                        'target' => ExportMenu::TARGET_BLANK,
                        'fontAwesome' => true,
                        'dropdownOptions' => [
                            'label' => 'Full',
                            'class' => 'btn btn-default',
                            'itemsBefore' => [
                                '<li class="dropdown-header">Export All Data</li>',
                            ],
                        ],
                        'exportConfig' => [
                            ExportMenu::FORMAT_PDF => false
                        ]
                    ]),
                ],
            ]); ?>
        </div>
    </div>
</div>


<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
    $(document).on('change', 'select[id^=status_list_]', function() {
        var id = $(this).attr('data-id');
        var val = $(this).val();

        $.ajax({
            type: "POST",

            url: "/admin/skipper-payout/update-status",


            data: {
                id: id,
                val: val
            },
            success: function(data) {
                swal("Good job!", "Status Successfully Changed!", "success").then(function() {
                    location.reload();
                });;
            }
        });
    });
</script>