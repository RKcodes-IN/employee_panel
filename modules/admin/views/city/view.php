<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;
use app\models\User;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\City */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Cities'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="city-view">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-9">
                    <h2><?= Yii::t('app', 'City') . ' ' . Html::encode($this->title) ?></h2>
                </div>
                <div class="col-sm-3" style="margin-top: 15px">

                    <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                    <?php if (\Yii::$app->user->identity->user_role == User::ROLE_ADMIN || \Yii::$app->user->identity->user_role == User::ROLE_SUBADMIN) { ?>
                        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
                            'class' => 'btn btn-danger',
                            'data' => [
                                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                                'method' => 'post',
                            ],
                        ])
                        ?>
                    <?php  } ?>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">

            <div class="row">
                <?php
                $gridColumn = [
                    ['attribute' => 'id', 'visible' => false],
                    'name',
                    'status',
                ];
                echo DetailView::widget([
                    'model' => $model,
                    'attributes' => $gridColumn
                ]);
                ?>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <h4>RideCommision<?= ' ' . Html::encode($this->title) ?></h4>
            </div>
            <?php
            $gridColumnRideCommision = [
                'city_id',
                'vehicle_id',
                'base_fare',
                'min_distance',
                'fare_per_distance',
                'waiting_time_limit',
                'charges_per_minute',
                'fare_per_minute',
                'no_of_person',
                'commision',
                'status',
            ];
            echo DetailView::widget([
                'model' => $model->id0,
                'attributes' => $gridColumnRideCommision
            ]);
            ?>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <?php
                if ($providerPincode->totalCount) {
                    $gridColumnPincode = [
                        ['class' => 'yii\grid\SerialColumn'],
                        ['attribute' => 'id', 'visible' => false],
                        'name',
                        [
                            'attribute' => 'vehical.title',
                            'label' => Yii::t('app', 'Vehical')
                        ],
                        'price',
                        'status',
                    ];
                    echo Gridview::widget([
                        'dataProvider' => $providerPincode,
                        'pjax' => true,
                        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-pincode']],
                        'panel' => [
                            'type' => GridView::TYPE_PRIMARY,
                            'heading' => '<span class="glyphicon glyphicon-book"></span> ' . Html::encode(Yii::t('app', 'Pincode')),
                        ],
                        'export' => false,
                        'columns' => $gridColumnPincode
                    ]);
                }

                ?>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <?php
                if (!empty($providerRideCommision)) {
                    if ($providerRideCommision->totalCount) {
                        $gridColumnRideCommision = [
                            ['class' => 'yii\grid\SerialColumn'],
                            ['attribute' => 'id', 'visible' => false],
                            [
                                'attribute' => 'vehicle.title',
                                'label' => Yii::t('app', 'Vehicle')
                            ],
                            'base_fare',
                            'min_distance',
                            'fare_per_distance',
                            'waiting_time_limit',
                            'charges_per_minute',
                            'fare_per_minute',
                            'no_of_person',
                            'commision',
                            'status',
                        ];
                        echo Gridview::widget([
                            'dataProvider' => $providerRideCommision,
                            'pjax' => true,
                            'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-ride-commision']],
                            'panel' => [
                                'type' => GridView::TYPE_PRIMARY,
                                'heading' => '<span class="glyphicon glyphicon-book"></span> ' . Html::encode(Yii::t('app', 'Ride Commision')),
                            ],
                            'export' => false,
                            'columns' => $gridColumnRideCommision
                        ]);
                    }
                }


                ?>
            </div>
        </div>
    </div>

</div>