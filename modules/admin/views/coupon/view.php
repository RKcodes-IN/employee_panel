<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;
use app\models\User;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Coupon */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Coupons'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="coupon-view">
<div class="card">
       <div class="card-body">
    <div class="row">
        <div class="col-sm-9">
            <h2><?= Yii::t('app', 'Coupon').' '. Html::encode($this->title) ?></h2>
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
        'description:ntext',
        'code',
        'discount',
        'max_discount',
        'min_ride_amount',
        'max_use',
        'max_use_of_coupon',
        'start_date',
        'end_date',
        'is_global',
        'status',
        'type_id',
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
<?php
if($providerCouponsApplied->totalCount){
    $gridColumnCouponsApplied = [
        ['class' => 'yii\grid\SerialColumn'],
            ['attribute' => 'id', 'visible' => false],
            [
                'attribute' => 'ride.id',
                'label' => Yii::t('app', 'Ride')
            ],
                        'status',
            'type_id',
    ];
    echo Gridview::widget([
        'dataProvider' => $providerCouponsApplied,
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-coupons-applied']],
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => '<span class="glyphicon glyphicon-book"></span> ' . Html::encode(Yii::t('app', 'Coupons Applied')),
        ],
        'export' => false,
        'columns' => $gridColumnCouponsApplied
    ]);
}

?>
</div>
</div>
</div>

</div>

