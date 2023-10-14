<?php

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\search\DriverDetailsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

use yii\helpers\Html;
use kartik\export\ExportMenu;
use app\models\User;
use app\modules\admin\models\base\BankDetail;
use app\modules\admin\models\base\Banner;
use app\modules\admin\models\DriverDetails;
use app\modules\admin\models\search\BankDetailSearch;
use kartik\grid\GridView;

$this->title = Yii::t('app', 'Skipper Details');
$this->params['breadcrumbs'][] = $this->title;
$search = "$('.search-button').click(function(){
	$('.search-form').toggle(1000);
	return false;
});";
$this->registerJs($search);


?>
<div class="driver-details-index">
    <div class="card">
        <div class="card-body">

            <?php // echo $this->render('_search', ['model' => $searchModel]); 
            ?>

            <p>


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

                    'attribute' => 'online_status',
                    'format' => 'raw',
                    'label' => Yii::t('app', 'Online Status'),
                    'value' => function ($model) {
                        if (!empty($model->user->online_status ?? '')) {
                            return $model->user->getOnlineStatusBadges();
                        } else {
                            return "";
                        }
                    },

                    'filter'  =>  \app\models\User::getOnlineStatus(),


                ],
                [
                    'attribute' => 'is_verified',
                    // 'filter'  =>  DriverDetails::getVerifyOptions(),
                    'format' => 'raw',
                    'value' => function ($model) {
                        return $model->getVerifyOptionsBadges();
                    },
                    'filter'  => (new DriverDetails)->getVerifyOptions(),


                ],
                [
                    'attribute' => 'user_id',
                    'label' => Yii::t('app', 'User'),
                    'value' => function ($model) {
                        $first_name  = $model->user->first_name ?? '';
                        $last_name  = $model->user->last_name ?? '';

                        return $first_name . ' ' . $last_name;
                    },
                    // 'filterType' => GridView::FILTER_SELECT2,
                    // 'filter' => \yii\helpers\ArrayHelper::map(\app\models\User::find()->where(['user_role' => User::ROLE_SKIPPER])->asArray()->all(), 'id', 'username'),
                    // 'filterWidgetOptions' => [
                    //     'pluginOptions' => ['allowClear' => true],
                    // ],
                    // 'filterInputOptions' => ['placeholder' => 'User', 'id' => 'grid-driver-details-search-user_id']
                ],

                //bank-name text field
                [

                    'attribute' => 'user_id',
                    'format' => 'raw',
                    'label' => Yii::t('app', 'Bank name'),
                    'value' => function ($model) {


                        $bank_name = $model->bankDetail->bank_name ?? '';
                        return  $bank_name;
                    },

                ],

                //    bank-account-number

                [

                    'attribute' => 'user_id',
                    'format' => 'raw',
                    'label' => Yii::t('app', 'Account number'),
                    'value' => function ($model) {


                        $account_number = $model->bankDetail->account_number ?? '';
                        return  $account_number;
                    },

                ],

                //  bank-ifsc code

                [

                    'attribute' => 'user_id',
                    'format' => 'raw',
                    'label' => Yii::t('app', 'ifsc code'),
                    'value' => function ($model) {


                        $ifsc_code = $model->bankDetail->ifsc_code ?? '';
                        return  $ifsc_code;
                    },

                ],
                'vehical_type',
                'vehical_owner',


                // phone number


                [

                    'attribute' => 'user_id',
                    'format' => 'raw',
                    'label' => Yii::t('app', 'phone number'),
                    'value' => function ($model) {


                        $contact_no = $model->user->contact_no ?? '';
                        return  $contact_no;
                    },

                ],






                // 'address',


                'license_no',
                // [
                //     'attribute' => 'proof_of_license',
                //     'format' => 'raw',
                //     'value' => function ($model) {
                //         return Html::img(
                //             $model['proof_of_license'],
                //             [
                //                 'width' => '180px',
                //                 'height' => '100px'
                //             ]
                //         );
                //     },


                // ],

                // [
                //     'attribute' => 'proof_of_license_back',
                //     'format' => 'raw',
                //     'value' => function ($model) {
                //         return Html::img(
                //             $model['proof_of_license_back'],
                //             [
                //                 'width' => '180px',
                //                 'height' => '100px'
                //             ]
                //         );
                //     },


                // ],


                [
                    'attribute' => 'vehical_id',
                    'label' => Yii::t('app', 'Vehicle'),
                    'value' => function ($model) {
                        return $model->vehical->title ?? '';
                    },
                    'filterType' => GridView::FILTER_SELECT2,
                    'filter' => \yii\helpers\ArrayHelper::map(\app\modules\admin\models\Vehicals::find()->asArray()->all(), 'id', 'title'),
                    'filterWidgetOptions' => [
                        'pluginOptions' => ['allowClear' => true],
                    ],
                    'filterInputOptions' => ['placeholder' => 'Vehicle', 'id' => 'grid-driver-details-search-vehical_id']
                ],


                // vehicle type


                'rc_number',









                'pan_number',

                'created_on',




                [
                    'class' => 'kartik\grid\ActionColumn',
                    'template' => '{view} {update} ',
                    'buttons' => [
                        'view' => function ($url, $model) {
                            if (\Yii::$app->user->identity->user_role == User::ROLE_ADMIN) {
                                return Html::a('<span class="fas fa-eye" aria-hidden="true"></span>', $url);
                            }
                        },
                        'update' => function ($url, $model) {
                            if (\Yii::$app->user->identity->user_role == User::ROLE_ADMIN) {
                                return Html::a('<span class="fas fa-pencil-alt" aria-hidden="true"></span>', $url);
                            }
                        },
                        'delete' => function ($url, $model) {
                            if (\Yii::$app->user->identity->user_role == User::ROLE_ADMIN) {
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
                'headerContainer' => ['class' => 'border-0', 'style' => 'border-bottom:none !important; border-top:0 !important;'],
                'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-city']],

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

            url: "/easygo_backend/gii/default/status-change",


            data: {
                id: id,
                val: val
            },
            success: function(data) {
                swal("Good job!", "Status Successfully Changed!", "success");
            }
        });
    });
</script>